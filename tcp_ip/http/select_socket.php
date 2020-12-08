<?php
$port = 9050;
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($sock, '127.0.0.1', $port);
socket_listen($sock);
// create a list of all the clients that will be connected to us..
// add the listening socket to this list
socket_set_block($sock);
$clients = array($sock);
while (true) {
    $read = $clients;
    // get a list of all the clients that have data to be read from
    // if there are no clients with data, go to next iteration
    if (socket_select($read, $write = NULL, $except = NULL, 1) < 1) {
        echo 111;
        continue;
    }

    // check if there is a client trying to connect
    if (in_array($sock, $read)) {
        // accept the client, and add him to the $clients array
        $clients[] = $newsock = socket_accept($sock);

        // send the client a welcome message
        socket_write($newsock, "no noobs, but ill make an exception :)\n".
            "There are ".(count($clients) - 1)." client(s) connected to the server\n");

        socket_getpeername($newsock, $ip);
        echo "New client connected: {$ip}\n";

        // remove the listening socket from the clients-with-data array
        $key = array_search($sock, $read);
        unset($read[$key]);
    }
}

// close the listening socket
socket_close($sock);
?>