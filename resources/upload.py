import os
from dotenv import load_dotenv
from pathlib import Path
import mysql.connector


dotenv_path = Path(os.path.dirname(os.path.abspath(__file__))) / "../.env"
load_dotenv(dotenv_path)

lhost = os.getenv('DB_HOST')
lport = os.getenv('DB_PORT')
lusername = os.getenv('DB_USERNAME')
lpassword = os.getenv('DB_PASSWORD')
ldatabase = os.getenv('DB_DATABASE')



passwords = ["z@,j8_9B}r","T'jpKrJ2*N","S.c;QB97rJ","k4BAg5M;}a","S=n#@y>k2*","y!U[es5wQ8","mc_L>[R@9V","J5`jt_~^K?","K}(zn6<@FW","gq5h#vPJ>$"]
VmDB = mysql.connector.connect(host=lhost, port=lport, user=lusername, passwd=lpassword, database=ldatabase)
print(f"Connection to VoteMe {'Successful' if VmDB else 'Failed' }")

vm = VmDB.cursor()

for password in passwords:
    sqlform = f"Insert ignore into CodiciDelegato (Codice,Usato) values(\"{password}\",0)"
    vm.execute(sqlform)
    VmDB.commit()



print("Task 1 done")
