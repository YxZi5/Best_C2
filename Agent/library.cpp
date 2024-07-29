#include <string>
#include <iostream>

using namespace std;

unsigned char* conv_to_tab(string text, int len) {
	unsigned char* tab = new unsigned char[len];

	for (size_t i = 0; i < len; i++) {
		tab[i] = text[i];
	}

	return tab;
}

unsigned char* decryptShellcode(unsigned char encShellcode[], int shellcodeLength, unsigned char xorKey) {
  unsigned char* decryptedShellcode = new unsigned char[shellcodeLength];
  
  // Decrypt each hex character using XOR function
  for (int i = 0; i < shellcodeLength - 1; i++) {
    decryptedShellcode[i] = encShellcode[i] ^ xorKey;
  }

  decryptedShellcode[shellcodeLength] = '\n';

  return decryptedShellcode;
}

