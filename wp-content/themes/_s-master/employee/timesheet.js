var $j = jQuery.noConflict();

        $j(document).ready(function() {


            $j(".firstweek").blur(function() {

                var sum1 = 0;

                $j('.totalhour').each(function(index, value) {
                    if (index <= 6) {
                        sum1 += Number($j(this).val());
                    }
                });

                if (sum1 >= 20) {
                    var explain1 = prompt("You logged more than 20 hours. Please explain why", "explain here");
                    $j(".explain_ftwk").attr("value", explain1);
                }
            });


            $j(".secondweek").blur(function() {

                var sum2 = 0;

                $j('.totalhour').each(function(index, value) {
                    if (index >= 7) {
                        sum2 += Number($j(this).val());
                   }
                });

                if (sum2 >= 20) {
                    var explain2 = prompt("You logged more than 20 hours. Please explain why", "explain here");
                    $j(".explain_snwk").attr("value", explain2);
                }
            });

            $j(".totalhour").blur(function() {

                var sum2 = 0;
                var sum3 = 0;

                $j('.totalhour').each(function(index, value) {
                      sum3 += Number($j(this).val());
                });

               $j('.tothrs_totalhour').val(sum3);
            });
                        
        });