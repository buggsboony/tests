import requests
import socket
local_ip=socket.gethostbyname(socket.gethostname())
print(local_ip)

url = 'http://localhost:8080/test.php'
myobj = {'somekey': 'somevalue'}

x = requests.post(url, data = myobj)

print(x.text)

#écrire dans un fichier et lire aussi

d_path = 'dog_breeds.txt'
d_r_path = 'dog_breeds_reversed.txt'
with open(d_path, 'r') as reader, open(d_r_path, 'w') as writer:
    dog_breeds = reader.readlines()
    writer.writelines(reversed(dog_breeds))
