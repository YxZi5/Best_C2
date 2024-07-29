# Best_C2


### Description

Simple c2 server, with one main functionality - access to shell of infected host. Server is builed with PHP and MySQL, agent is writed in C++ but server gives access to API endpoints, so we can use all kind of languages to write client, which will be sending requests to these API endpoints. Server use MySQL in very dynamic way. Examples: One endpoint responsible for recive the output from executed command, automatically delete this output from database. Next endpoint responsible for save output in database, automatically makes that this command is deleted from database. This means that, data in database are saving and deleting very dinamic during the agent is running on client.

Presentation the functionality: https://youtu.be/lquoPNmM7s4?si=DMtImyFi6JIfGHnx

