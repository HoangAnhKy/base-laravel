<?php

define("LIMIT", 10);
define("POST", "POST");
define("GET", "GET");
define("PUT", "PUT");
define("DELETE", "DELETE");

define("DEL", 1);
define("UNDEL", 0);

define("INACTIVE", 0);
define("ACTIVE", 1);

define("TEACHER", 0);
define("STUDENT", 1);

define("LIST_POSITION", [
    TEACHER => "Teacher",
    STUDENT => "Student"
]);

define("LIST_STATUS", [
    INACTIVE => "In Active",
    ACTIVE => "Active"
]);


define("READ", 1);
define("UNREAD", 0);
define("BASE_URL", "https://school.local.com");
