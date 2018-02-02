A task:
=====================
Calculate the difference between 2 input dates without using any PHP functions related to the date.

Incoming data:
---------------------------------------------------------------------------
2 dates in the format `"YYYY-MM-DD" (2015-03-05, for example)`

Outgoing data:
---------------------------------------------------------------------------
```php
stdClass {
int $years, Number of years between dates
int $months, Number of months between dates
int $days, Number of days between dates
int $total_days, Total number of days between two dates
bool $invert true - if the start date> end date
}
```

WITHOUT using any frameworks, only pure PHP

Without using the DateTime class


Useful links:
====================
* JQuery UI Datepicker

<https://jqueryui.com/datepicker/>

* Checking For Leap Year Using PHP

<https://davidwalsh.name/checking-for-leap-year-using-php>

<https://stackoverflow.com/questions/17924481/find-leap-years>

* stdClass

<https://stackoverflow.com/questions/931407/what-is-stdclass-in-php>

<https://www.webmaster-source.com/2009/08/20/php-stdclass-storing-data-object-instead-array/>