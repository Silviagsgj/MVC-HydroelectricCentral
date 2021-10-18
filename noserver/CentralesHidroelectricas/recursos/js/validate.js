const validateDni = (dni) => {
    const validChars = 'TRWAGMYFPDXBNJZSQVHLCKET'
    const nifRexp = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i
    const nieRexp = /^[XYZ]{1}[0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i
    const str = dni.toString().toUpperCase()

    if(!nifRexp.test(str) && !nieRexp.test(str)) console.log('DNI incorrecto')

    const nie = str
        .replace(/^[X]/, '0')
        .replace(/^[Y]/, '1')
        .replace(/^[Z]/, '2')

    const letter = str.substr(-1)
    const charIndex = parseInt(nie.substr(0, 8)) % 23

    if(validChars.charAt(charIndex) === letter) return true
    else return false
}

const validateEmail = (email) => {
    const emailRegex = /^(([^<>()\[\]\\.,:\s@"]+(\.[^<>()\[\]\\.,:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    
    if(emailRegex.test(email)) return true
    else return false
}


const validateFechanac = (fecha) => {
    
    
    const hoy  = new Date();
  let partes = fecha.split('-');

 if (partes[0] == hoy.getFullYear()){

     //compruebo el mes
       if(Number(partes[1]) == hoy.getMonth()+1){
           //compruebo el dia
                    if(Number(partes[2]) == hoy.getDate()){
          return true;
      }
             if(Number(partes[2]) < hoy.getDate()){
          return true;
      }
               if(Number(partes[2]) > hoy.getDate()){
          return false;
      }
       }
     
      if(Number(partes[1]) < hoy.getMonth()+1){
          return true;
      }
      if(Number(partes[1]) > hoy.getMonth()+1){
          return false;
      }
 }else{


 if (partes[0] < hoy.getFullYear()){
    return true;
  
 }
 
  if (partes[0] > hoy.getFullYear()){
    return false;
 
 }
}}

const validateIban = (iban) => {
    const ibanRegex = /([A-Z]{2})\s*\t*(\d\d)\s*\t*(\d\d\d\d)\s*\t*(\d\d\d\d)\s*\t*(\d\d)\s*\t*(\d\d\d\d\d\d\d\d\d\d)/g

    if(ibanRegex.test(iban)) return true
    else return false
}

const validateTelefono = (telefono) => {
    const telefonoRegex =/^\d{9}$/

    if(telefonoRegex.test(telefono)) return true
    else return false
}


const validateCP = (cp) => {
    const cpRegex =/^(?:0?[1-9]|[1-4]\d|5[0-2])\d{3}$/

    if(cpRegex.test(cp)) return true
    else return false
}

const validateCIF = (cif) => {
    const cifRegex =/^[a-zA-Z]{1}\d{7}[a-zA-Z0-9]{1}$/

    if(cifRegex.test(cif)) return true
    else return false
}


function validateDecimal(valor) {
    const valorRegex = /^\d*(\.\d{1})?\d{0,1}$/;
    if (valorRegex.test(valor)) {
        return true;
    } else {
        return false;
    }
}

const validateNoCaracteresEspeciales = (valor) => {
    const valorRegex =/^[a-z 0-9 ÁÉÍÓÚáéíóúñÑ ]+$/i

    if(valorRegex.test(valor)) return true
    else return false
}

const validateNoCaracteresEspecialesDirDes = (valor) => {
    const valorRegex =/^[a-z 0-9 ÁÉÍÓÚáéíóúñÑ ,./]+$/i

    if(valorRegex.test(valor)) return true
    else return false
}

const validateNoCaracteresEspecialesNiNumeros = (valor) => {
    const valorRegex =/^[a-z ÁÉÍÓÚáéíóúñÑ ]+$/i

    if(valorRegex.test(valor)) return true
    else return false
}

const validatePasswordComplex = (password) => {   
    const passwordRegex = /(?=(.*[0-9]))(?=.*[\!@#$%^&*()\\[\]{}\-_+=~`|:"'<>,./?])(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/
    if(passwordRegex.test(password)) return true
    else return false
}

const validatePasswordModerate = (password) => {
    const passwordRegex = /(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/
    if(passwordRegex.test(password)) return true
    else return false
}

const validateUsername = (username) => {  
    const usernameRegex = /^[a-z0-9_-]{3,16}$/
    if(usernameRegex.test(username)) console.log('username válido')
    else console.log('username incorrecto')
}

const validateUrl = (url) => {
    const urlRegex = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#()?&//=]*)/
    if(urlRegex.test(url)) console.log('url válida')
    else console.log('url incorrecta')
}

const validateIP = (ip) => {
    const ipRegex = /((^\s*((([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))\s*$)|(^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$))/g
    if(ipRegex.test(ip)) console.log('ip válida')
    else console.log('ip incorrecta')
}

const validateHexadecimal = (hexadecimal) => {
    const hexadecimalRegex = /^#?([a-f0-9]{6}|[a-f0-9]{3})$/
    if(hexadecimalRegex.test(hexadecimal)) console.log('hexadecimal válido')
    else console.log('hexadecimal incorrecto')
}

const validateCreditCard = (card) => {
    const creditCardRegex = /^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/
    if(creditCardRegex.test(card)) return true
    else return false
}
