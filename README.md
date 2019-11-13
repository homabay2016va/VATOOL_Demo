# VATOOL_Demo

VA Dashboard application VATOOL is a web based application aimed at providing visualisations of VA data and COD information obtained after successfully running/executing OpenVA pipeline. The tool also provides information that is informative on VA data quality and also CSMF based on aspects like age group and sex in a specific year.

# Installation and use
Make sure you have installed openva_pipeline. [https://openva-pipeline.readthedocs.io/en/latest/install.html]
Make sure you also install postgres database

Copy the folder/zip file to any of your directory.

Download and Install Xampp [https://vitux.com/how-to-install-xampp-on-your-ubuntu-18-04-lts-system/] (for Windows use wampserver/Xampp)

for Linux
Navigate to computer/opt/lamp/htdocs/ and paste the "VATOOL_Demo" folder there.


Open the "files_to_run" folder and locate the following:

## quick setup 
demova.sql - this is the postgres database backup, go to postgres and restore the file for quick setup.

## for manual setup
• vadata.csv – This is the original va data (demo data for this purpose)

• icd10.csv – A list of ICD10 causes and codes. (for information- not used by the python code but by the pipeline_cod.R code)

• pipeline_cod.R - Customized code for running COD using both Insilico and InterVA and produces the "merged_cod_va.csv" file. Begin by opening this and make necessary adjustment to run with your data. End product should be the following file.

• merged_cod_va.csv – This is the va data that is merged with respective COD and ICD10 codes. This is important file for the dashboard python code. 

• python_code.py – This is python code that will pick the "merged_cod_va.csv" and run analytics/data checks on it. In future, this code should be incooporated into the OpenVA pipeline for easy use and installation. Then execute this file after executing the R file. This also pushes data to postgres database for use by the dashboard.


Once the python code executes successfully, you can now go to your browser and enter IP address/DNS of your server. If within the server you can use localhost, then apache port then application name. i.e.

Type http://dns:port/CRVS or http://localhost/CRVS (If your apache runs in port 80)

Dashboard is ready for use.

Further documentation is also in this folder "VATOOL_documentation.pdf"

# Future updates
Have a desktop app that is customizable and easier to install and use. Doing away with need to install webserver. Thank you!

Developed by:
Odhiambo Collins Ochieng
Software Developer
Email:qollinsochieng@gmail.com
