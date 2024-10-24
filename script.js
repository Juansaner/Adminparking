const container = document.querySelector(".container");
const btnsignIn = document.getElementById("btn-sign-in");
const btnsignUp = document.getElementById("btn-sign-up");

btnsignIn.addEventListener("click",()=>{
    container.classList.remove("toggle");
});

btnsignUp.addEventListener("click",()=>{
    container.classList.add("toggle");
});