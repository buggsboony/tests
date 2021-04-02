#!/usr/bin/env python

# WS server example

import asyncio
import websockets
import sys



#!/usr/bin/env python

import asyncio
import websockets

async def echo(websocket, path):
    try:
       async for message in websocket:
            await websocket.send('Serveur : je recois ceci: '+message)
            print('message reçu : "'+message+"'")
    except:
        print('Quelque chose a mal tourné !')
        print(sys.exc_info()[0])


asyncio.get_event_loop().run_until_complete(
    websockets.serve(echo, 'localhost', 8765))
asyncio.get_event_loop().run_forever()









# async def hello(websocket, path):
#     try:
#         print ('hello fonction')
#         name = await websocket.recv()
#         print(f"< {name}")

#         greeting = f"Hello {name}!"

#         await websocket.send(greeting)
#         print(f"> {greeting}")
#     except:
#         print('bon, quelque chose a planté')
#         print('ERR: ',sys.exc_info()[0])

# start_server = websockets.serve(hello, "localhost", 8765)

# asyncio.get_event_loop().run_until_complete(start_server)
# asyncio.get_event_loop().run_forever()
