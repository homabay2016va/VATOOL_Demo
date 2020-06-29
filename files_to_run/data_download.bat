@echo 

if exist va1.csv del va1.csv

timeout /t 5
java -jar "ODK-Briefcase-v1.14.0.jar" -plla -id zm_va_who_v1_5_2_7 -sd storage -url ODKAGGREGATE_SERVER_URL --odk_username aggregateusername --odk_password aggregatepassword
java -jar "ODK-Briefcase-v1.14.0.jar" -e -id zm_va_who_v1_5_2_7 -sd storage -ed . -f va1.csv


timeout /t 165
exit
