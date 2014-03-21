            $(document).ready(function() {
                $('#TI_Hora_Inicio_Am').timepicker({
                    showLeadingZero: false,
                    onHourShow: tpStartOnHourShowCallback,
                    onMinuteShow: tpStartOnMinuteShowCallback
                });
                $('#TI_Hora_Final_Am').timepicker({
                    showLeadingZero: false,
                    onHourShow: tpEndOnHourShowCallback,
                    onMinuteShow: tpEndOnMinuteShowCallback
                });
            });

            function tpStartOnHourShowCallback(hour) {
                var tpEndHour = $('#TI_Hora_Final_Am').timepicker('getHour');
                // all valid if no end time selected
                if ($('#TI_Hora_Final_Am').val() == '') { return true; }
                // Check if proposed hour is prior or equal to selected end time hour
                if (hour <= tpEndHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpStartOnMinuteShowCallback(hour, minute) {
                var tpEndHour = $('#TI_Hora_Final_Am').timepicker('getHour');
                var tpEndMinute = $('#TI_Hora_Final_Am').timepicker('getMinute');
                // all valid if no end time selected
                if ($('#TI_Hora_Final_Am').val() == '') { return true; }
                // Check if proposed hour is prior to selected end time hour
                if (hour < tpEndHour) { return true; }
                // Check if proposed hour is equal to selected end time hour and minutes is prior
                if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }

            function tpEndOnHourShowCallback(hour) {
                var tpStartHour = $('#TI_Hora_Inicio_Am').timepicker('getHour');
                // all valid if no start time selected
                if ($('#TI_Hora_Inicio_Am').val() == '') { return true; }
                // Check if proposed hour is after or equal to selected start time hour
                if (hour >= tpStartHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpEndOnMinuteShowCallback(hour, minute) {
                var tpStartHour = $('#TI_Hora_Inicio_Am').timepicker('getHour');
                var tpStartMinute = $('#TI_Hora_Inicio_Am').timepicker('getMinute');
                // all valid if no start time selected
                if ($('#TI_Hora_Inicio_Am').val() == '') { return true; }
                // Check if proposed hour is after selected start time hour
                if (hour > tpStartHour) { return true; }
                // Check if proposed hour is equal to selected start time hour and minutes is after
                if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }// JavaScript Document