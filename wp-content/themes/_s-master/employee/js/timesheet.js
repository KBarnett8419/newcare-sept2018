var $j = jQuery.noConflict();

$j(document).ready(function() {


    /* Submit Time Sheet Form*/

    $j(".update_submit_btn").click(function() {

        var sum1 = 0;
        var wkhr = $j("#hr_per_wk").val();

        $j('.totalhour').each(function(index, value) {
            if (index <= 6) {
                sum1 += Number($j(this).val());
            }
        });

        if (sum1 >= wkhr) {

            var explain = $j(".explain_ftwk").val();

            if (explain == "") {
                var explain1 = prompt("You logged more than 20 hours. Please explain why", "explain here");
                $j(".explain_ftwk").attr("value", explain1);
            } else {
                if ($j("#timshtfrm").valid()) {
                    $j("#timshtfrm").submit();
                }
            }

        } else {
            if ($j("#timshtfrm").valid()) {
                $j("#timshtfrm").submit();
            }
        }

    });


    /* Submit Supervisor Form */

    $j(".superv_next").click(function() {

         if($j("#timshtfrm").valid()) {
           
            $j("#suprb").css({
                display: 'none'
            });

            $j(".timesheet_form").css({
                display: 'block'
            });

            var vdate = $j("#datepicker1").val();

            $j("#visitdate").text("Visit Date: "+vdate);

         }
        
    });

    /* Total Hour Count */

    $j(".totalhour").blur(function() {

        var sum2 = 0;
        var sum3 = 0;

        $j('.totalhour').each(function(index, value) {
            sum3 += Number($j(this).val());
        });

        $j('.tothrs_totalhour').val(sum3);
    });


    /* Time Count from Start and End */

    $j('.totalhour').each(function(index, value) {

        var sl = index + 1;

        $j(".et" + sl).blur(function() {
            var start = $j(".st" + sl).val();
            var end = $j(".et" + sl).val();

            s = start.split(':');

            e = end.split(':');

            min = e[1] - s[1];
            hour_carry = 0;
            if (min < 0) {
                min += 60;
                hour_carry += 1;
            }
            hour = e[0] - s[0] - hour_carry;
            diff = hour + "." + min;

            $j('.tlhr' + sl).val(diff);

        });

    });

    /* Date Picker */

    $j( "#datepicker" ).datepicker({ dateFormat: 'mm-dd-yy' });
    $j( "#datepicker1" ).datepicker({ dateFormat: 'mm-dd-yy' });
    $j( "#datepickertime" ).datepicker({ dateFormat: 'mm-dd-yy' });
    $j( "#datepickertime1" ).datepicker({ dateFormat: 'mm-dd-yy' });



});