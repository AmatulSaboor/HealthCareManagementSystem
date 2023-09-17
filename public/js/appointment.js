let working_days = [];
$(document).ready(function () {
    let doctorUrl = $("#field_id").data('doctorurl');
    let dayUrl = $("#doctor_dropdown").data('dayurl');
    let timeUrl = $("#doctor_dropdown").data('timeurl');
    console.log(doctorUrl + ' | ' + dayUrl + ' | ' + timeUrl);

    if($("#field_id").val()){
        loadDoctors($("#field_id").val(), doctorUrl, timeUrl, dayUrl)
    }
    $("#field_id").on('change',function () {
        let params = $(this).val(); 
        loadDoctors(params, doctorUrl, timeUrl, dayUrl);
    })
    $('#doctor_dropdown').on('change', function () {
        let selected_doctor_id = $(this).val();
        getDoctorDetails(selected_doctor_id, timeUrl, dayUrl)
    });
    $("#appointment_date").on('input', function () {
        let selected_date = new Date($(this).val());
        if(selected_date.getDay() == 0){
            alert("Doctor not working on sundays");
                this.value = "";
        }
        else if (working_days.length > 0 && !working_days.includes(selected_date.getDay())) {
                alert("Doctor not working on this day of the week");
                this.value = "";
            }
        }
    );
});

// --------- FUNCTION : load doctor drop down on field selection --------------
function loadDoctors(params, doctorUrl, timeUrl, dayUrl) {
    ajaxGet(doctorUrl + '/' +params,{},(status,data)=>{
        if (status){
            $("#doctor_dropdown").empty();
            if (data.length > 0){
                for(let item of data){
                    let old_value = "{{old('doctor_id')}}"
                    let selected = (item.user_id == old_value) ? 'selected' : '';
                    console.log(item.user_id + 'in doctor' +  old_value)
                    $("#doctor_dropdown").append("<option value='"+item.user_id+"' " + selected + ">"+item.user.name+"</option>");
                }
            }else{
                $("#doctor_dropdown").append("<option value=''>no doctor available</option>");
                $("#appointment_time_dropdwon").empty();
                $("#appointment_time_dropdwon").append("<option value=''>choose doctor first</option>");
            }
            if(data.length > 0){
                getDoctorDetails(data[0].user_id, timeUrl, dayUrl)}
        }else{console.log("error:",data);}
    })
}

// --------- FUNCTION : get doctor details on doctor selection (timings and working hours) -------------
function getDoctorDetails(doctor_id, timeUrl, dayUrl){
    ajaxGet(timeUrl + "/" +doctor_id,{},(status,data)=>{
            if (status){
                $("#appointment_time_dropdwon").empty();
                for(let item of data){
                    let selected = (item == "{{old('appointment_time')}}") ? 'selected' : '';
                    console.log('in time' +selected)
                    $("#appointment_time_dropdwon").append("<option value='"+item+"' " + selected + ">"+item+"</option>");
                }
            }else{console.log("time error:",data);}
        }
    )
    ajaxGet(dayUrl + "/" +doctor_id,{},(status,data)=>{
        if (status){
            working_days = data;
            $("#doctor_days").empty();  
            $("#doctor_days").append("Doctor working days are "+ working_days.join(', '));
        }else{console.log("day error:",data);}
        }
    )
}