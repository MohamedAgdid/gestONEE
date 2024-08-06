const passwordValue = 1234;
const form = document.getElementById("form");
const serviceId = 'service_mzqubdh';
const email = "mohamedagdid447@gmail.com";
const templateId = 'template_h5eeb2x';
const publicKey = 'CF8Qd_4YYDY0eWnLj';

emailjs.init(publicKey);

form.addEventListener("submit", (e) => {
    e.preventDefault();
    const data = {
        password: passwordValue
    };
    emailjs.send(serviceId, templateId, data).then(
        () => {
            console.log("Success!");
        },
        (error) => {
            console.log(error);
        }
    );
});

    //     emailjs.send(serviceId,templateId,data).then(
    //     ()=>{
    //         input.value='';
    //     }


    //    );   //for remove the data we have in the end