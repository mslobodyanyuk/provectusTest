<?php header('Content-Type: text/html; charset=utf-8');
/** Index - default
 * view/DateInterval/index.php - displays the result of the method index of controller in the DateIntervalController
 */
?>
<title>Provectus test</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document). ready( function() {
            var minDate = new Date();
            $( "#datepicker" ).datepicker({
                minDate: minDate,
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель',
                    'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
                    'Октябрь', 'Ноябрь', 'Декабрь'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                dateFormat: 'dd.mm.yy',
                firstDay: 1,
                onClose: function(selectedDate){
                    $('#return').datepicker("option", "minDate", selectedDate);
                }
            })
        } );
    </script>
    <script>
        $(document). ready( function() {
            var minDate = new Date();
            $( "#datepicker1" ).datepicker({
                minDate: minDate,
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель',
                    'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
                    'Октябрь', 'Ноябрь', 'Декабрь'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                dateFormat: 'dd.mm.yy',
                firstDay: 1,
                onClose: function(selectedDate){
                    $('#return').datepicker("option", "minDate", selectedDate);
                }
            })
        } );
    </script>
</head>
<body>
<h1>Welcome to test program!!!</h1>
<h2>Pick two dates:</h2>
    <form action="/view" method="post" enctype="multipart/form-data">
        <input type="text"  id="datepicker" name="startDate" >
        To
        <input type="text"  id="datepicker1" name="endDate" >
        <input type="submit" value="Calculate">
    </form>
</body>


