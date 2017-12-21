# -*- coding: Utf-8 -*-


import io
import os
import requests
import xml.etree.ElementTree as ET
import sys
import getopt

from requests.packages.urllib3.exceptions import InsecureRequestWarning

ns = {'ev': 'http://schemas.xmlsoap.org/soap/envelope/'}
ns0= {'nsl': 'urn:local'}

header_soap="""<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<SOAP-ENV:Envelope 
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:fic="ficheid.webserv.experian.com"
    xmlns:obj="http://objet.ficheid.webserv.experian.com"
    xmlns:rec="http://rechdeno.methodes.ficheid.webserv.experian.com"
    xmlns:mns="java:com.experian.webserv.infogreffe"
    xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">"""
    
footer_body="""</arg0>
    </mns:getProduitsWebServicesXML>
  </SOAP-ENV:Body>"""
    
footer_soap="</SOAP-ENV:Envelope>"


def create_header_body(ident):
    
    header=""
    ligne=ident.split('-')
    if len(ligne)>=2:
        codeabonne=ligne[0]
        mdp=ligne[1]
    else:
        return(header)

    header="""<SOAP-ENV:Body> 
                <mns:getProduitsWebServicesXML> 
                <arg0 xsi:type="xsd:string" > 
                <demande> 
                <emetteur> 
                <code_abonne>"""+str(codeabonne)+"""</code_abonne> 
                <mot_passe>"""+str(mdp)+"""</mot_passe>""" 
   
    return(header)

def get_liste_depot(siren,num_depot,ident):
    

    requests.packages.urllib3.disable_warnings(InsecureRequestWarning)
    
    header_body=create_header_body(ident)
    
    if header_body=="":
        return("Pb d'identification")
        
    if len(ident.split('-'))==3:
        ref=ident.split('-')[2]
    else:
        ref="sans reference"
        
    body="""<code_requete>
        <type_profil>A</type_profil>
        <origine_emetteur>IC</origine_emetteur>
        <nature_requete>C</nature_requete>
        <type_document>AC
        </type_document>
        <type_requete>S</type_requete>
        <mode_diffusion>
        <mode type="T"/>
        </mode_diffusion>
        <media>WS</media>
        </code_requete>
        </emetteur>
        <commande>
        <num_siren>"""+siren+"""</num_siren>
        <num_depot>"""+num_depot+"""</num_depot>
        <reference_client>"""+str(ref)+"""</reference_client>
        <version_schema>6</version_schema>
        </commande>
        </demande>"""
    
    request=header_soap+header_body+body+footer_body+footer_soap
    
    encoded_request = request.encode('utf-8')
    headers = { "Content-Type": "text/xml;charset=UTF-8",
            "Content-Length": str(len(encoded_request)),
            "SOAPAction": "urn:getProduitsWebServicesXML"}

    response = requests.post(url="https://webservices.infogreffe.fr/WSContextInfogreffe/INFOGREFFE HTTP/1.1",
                     headers = headers,
                     data = encoded_request,
                     verify=False)

    tree = ET.fromstring(response.text)
    body_node=tree.find('ev:Body', ns)
    response_node=body_node.find('nsl:getProduitsWebServicesXMLResponse',ns0)
    return_node=response_node.find('return')    
    return(return_node)
    
def get_liste_actes(siren,ident):
    
    requests.packages.urllib3.disable_warnings(InsecureRequestWarning)
    
    header_body=create_header_body(ident)
    if header_body=="":
        return("Pb d'identification")
        
    if len(ident.split('-'))==3:
        ref=ident.split('-')[2]
    else:
        ref="sans reference"
        
    body="""<code_requete>
            <type_profil>A</type_profil>
            <origine_emetteur>IC</origine_emetteur>
            <nature_requete>C</nature_requete>
            <type_document>AC
            </type_document>
            <type_requete>S</type_requete>
            <mode_diffusion>
            <mode type="T"/>
            </mode_diffusion>
            <media>WS</media>
            </code_requete>
            </emetteur>
            <commande>
            <num_siren>"""+siren+"""</num_siren>
            <reference_client>"""+str(ref)+"""</reference_client>
            <version_schema>6</version_schema>
            </commande>
            </demande>"""
    request=header_soap+header_body+body+footer_body+footer_soap
    
    encoded_request = request.encode('utf-8')
    headers = { "Content-Type": "text/xml;charset=UTF-8",
            "Content-Length": str(len(encoded_request)),
            "SOAPAction": "urn:getProduitsWebServicesXML"}

    response = requests.post(url="https://webservices.infogreffe.fr/WSContextInfogreffe/INFOGREFFE HTTP/1.1",
                     headers = headers,
                     data = encoded_request,
                     verify=False)



    tree = ET.fromstring(response.text)
    body_node=tree.find('ev:Body', ns)
    response_node=body_node.find('nsl:getProduitsWebServicesXMLResponse',ns0)
    return_node=response_node.find('return')
    return(return_node)
    
    
def download_acte(url,siren,directory,date):

    
    r = requests.get(url)
    filename=directory+"/"+siren+"_DIBE_"+str(date)+".pdf"
    file=io.open(filename,"wb")
    file.write(r.content)
    file.close()  
        
# Programme principal


outdir="/tmp"
ident=""
filename=""

optlist, args = getopt.getopt(sys.argv[1:], 'f:d:i:')

for opt, arg in optlist:
    if opt in ("-d"):
        outdir=arg
    elif opt in ("-i"):
        ident=arg
    elif opt in ("-f"):
        filename=arg

liste_result=[]

        
if filename=="" or ident=="":
    print("le fichier csv ou l identification est manquant")
    exit(2)
    
try:
    filein=io.open(filename,'r',encoding='iso-8859-15')
except:
    print("Impossible d ouvrir le fichier :"+filename)
    exit(1)

outname, fileExtension = os.path.splitext(os.path.basename(filename))
outputname=outdir+"/"+outname+"_result.csv"

fileout=io.open(outputname,'w',encoding='iso-8859-15')


for line in filein:
    list_depot=[]
    etat_depot=0
    

    siren=line.split(';')[0].replace('\n','').replace(' ','')
    if siren.isdigit():
        
        liste_actes=get_liste_actes(siren,ident)
        if liste_actes=="Pb d'identification" :
            print("Pb d'identification")
            exit(3)
    
        return_text=liste_actes.text
        
        if return_text is None:
            # on recherche le depot BENh
            liste_depot_acte=liste_actes.find('liste_depot_acte')
    
            for depot_acte in liste_depot_acte.findall('depot_acte'):
                date_depot=depot_acte.find('date_depot').text
                for acte in depot_acte.findall('acte'):
                    type_acte=acte.find('type_acte').text
                    if type_acte=="BENh":
                        list_depot.append(siren)
                        list_depot.append(date_depot)
                        num_depot=depot_acte.find('num_depot').text
                        list_depot.append(num_depot)
                    
            
            nb_depot=int(len(list_depot)/3)
            
            if nb_depot > 1:
                date_old="1900-01-01"
                # on recherche le plus recent
                for i in range(nb_depot):
                    date=list_depot[3*i+1]
                    if date > date_old:
                        indice=i
                        date_old=date
                num_depot=list_depot[3*indice+2]
                datedepot=list_depot[3*indice+1]
            elif nb_depot == 1:
                num_depot=list_depot[2]
                datedepot=list_depot[1]
            else:
                liste_result.append(siren+";pas de depot DIBE pour ce siren; \n")
                etat_depot=1

            
            
            if etat_depot!=1:
                # appel du depot
                depot=get_liste_depot(siren,num_depot,ident)
                if depot=="Pb d'identification":
                    print("Pb d'identification")
                    exit(3)
                depot_acte=depot.find('depot_acte')
                acte=depot_acte.find('acte')
                url_acces=acte.find('url_acces')
                download_acte(url_acces.text,siren,outdir,datedepot)
                liste_result.append(siren+";"+str(datedepot)+"; OK \n")
            
        elif return_text[0:3]=="003":
            print("Pb d'identification")
            exit(3)
        else:
            liste_result.append(siren+";"+return_text+"; \n")
        
    else:
        siren=line.split(';')[0].replace('\n','').replace(' ','')
        print(siren)

    


        
for i in range(len(liste_result)):
    fileout.write(liste_result[i])
    
fileout.close()
filein.close()
exit(0)
    
    
    
    

    
        
    
    
    


#download_bilan_complet()
  
        

