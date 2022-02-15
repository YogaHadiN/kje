window.Echo.join('survey')
    .listen('CustomerSatisfactionSurveyPressence', (e) => {
        console.log(e);
    })
    .here((users) => {
        for (let i = 0, len = users.length; i < len; i++) {
            if(users[i].user.surveyable_type == 'App\\AntrianKasir'){
                $('#surveyable_id').val(users[i].user.surveyable_id);
                $('#surveyable_type').val(users[i].user.surveyable_type);
            }
        }
    })
    .joining((user) => {
        if( user.surveyable_type == 'App\\AntrianKasir'){
            $('#surveyable_id').val(users.user.surveyable_id);
        }
    })
    .leaving((user) => {
        if( user.surveyable_type == 'App\\AntrianKasir'){
            $('#surveyable_id').val('');
        }
    });

