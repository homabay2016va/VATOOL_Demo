# VATOOL_Demo

VA Dashboard application (VATOOL) is a web based application aimed at providing visualisations of VA data and COD reports and summaries, obtained after successfully running/executing OpenVA pipeline. VA and COD data summary will help in monitoring and evaluating VA data collection and also provides information that is informative on VA data quality and also CSMF based on aspects like age group and sex in a specific year. VA Data and COD information are extracted from OpenVA pipeline end results are saved in PostgreSQL database, where the dashboard will pick them for further data management tasks and analysis and finally displayed in the web portal. 

# Installation and use
Make sure you have installed openva_pipeline. [https://openva-pipeline.readthedocs.io/en/latest/install.html]
Make sure you also install postgres database

Copy the folder/zip file to any of your directory.

Download and Install Xampp [https://vitux.com/how-to-install-xampp-on-your-ubuntu-18-04-lts-system/] (for Windows use wampserver/Xampp)

for Linux
Navigate to computer/opt/lamp/htdocs/ and paste the "VATOOL_Demo" folder there.

N/B: Open home folder in the VATOOL_Demo directory, edit the sqlite_functions.php file to include your respective database credentials.


Open the "files_to_run" folder and locate the following:
•	python script – This is an automated program that executes all the necessary Bat files from beginning to end to update the database. 
•	R files:- Combines various VA data to one final file. (Incase you want to merge all previous collected data from other forms).
•	Bat files:- to execute R files on demand from the python program.

demova.sql backup file- this is the postgres database backup, go to postgres and restore the file for quick setup.


## quick setup 
After restoring the database, execute the "pipeline" python script.

Once the python code executes successfully, you can now go to your browser and enter IP address/DNS of your server. If within the server you can use localhost, then apache port then application name. i.e. (Type http://dns:port/your_app_folder_name or http://localhost/your_app_folder_name (If your apache runs in port 80))


Dashboard is ready for use.

Further documentation is also in this folder "VATOOL_documentation.pdf" and the video tutorial file.

Developed by:
Odhiambo Collins Ochieng
Software Developer
Email:qollinsochieng@gmail.com
