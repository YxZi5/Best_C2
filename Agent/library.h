#include <string>
#include <iostream>

using namespace std;

#pragma once

unsigned char* conv_to_tab(string text, int len);

unsigned char* decryptShellcode(unsigned char encShellcode[], int shellcodeLength, unsigned char xorKey);