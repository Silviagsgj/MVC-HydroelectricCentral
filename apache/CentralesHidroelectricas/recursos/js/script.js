let opp = document.getElementById("opp");
let formulario = document.getElementById("formulario");
let nombre= document.getElementById("nombre");
let modelo= document.getElementById("modelo");
let salariobase= document.getElementById("salariobase");
let horaextranormal= document.getElementById("horaextranormal");
let horaextranocturna= document.getElementById("horaextranocturna");
let horaextrafestivo= document.getElementById("horaextrafestivo");
let cif= document.getElementById("cif");
let telefono= document.getElementById("telefono");
let direccion= document.getElementById("direccion");
let constructor= document.getElementById("constructor");
let provincia= document.getElementById("provincia");
let poblacion= document.getElementById("poblacion");
let cp= document.getElementById("cp");
let descripcion= document.getElementById("descripcion");
let marca= document.getElementById("marca");
let stock= document.getElementById("stock");
let foto= document.getElementById("foto");
let tipoturbina= document.getElementById("tipoturbina");
let saltobruto= document.getElementById("saltobruto");
let numgeneradores= document.getElementById("numgeneradores");
let potencia= document.getElementById("potencia");
let tipo= document.getElementById("tipo");
let idcentral= document.getElementById("idcentral");
let dni= document.getElementById("dni");
let apellidos= document.getElementById("apellidos");
let fechanac= document.getElementById("fechanac");
let email= document.getElementById("email");
let rolusu= document.getElementById("rolusu");
let idcategoria= document.getElementById("idcategoria");
let coddepart= document.getElementById("coddepart");
let password = document.getElementById("clave");
let errornombre = document.getElementById("errornombre");
let errorsalariobase = document.getElementById("errorsalariobase");
let errorhoraextranormal = document.getElementById("errorhoraextranormal");
let errorhoraextranocturna = document.getElementById("errorhoraextranocturna");
let errorhoraextrafestivo = document.getElementById("errorhoraextrafestivo");
let errorcif = document.getElementById("errorcif");
let errortelefono = document.getElementById("errortelefono");
let errordireccion = document.getElementById("errordireccion");
let errorconstructor = document.getElementById("errorconstructor");
let errorprovincia = document.getElementById("errorprovincia");
let errorpoblacion = document.getElementById("errorpoblacion");
let errorcp = document.getElementById("errorcp");
let errordescripcion = document.getElementById("errordescripcion");
let errormarca = document.getElementById("errormarca");
let errorstock = document.getElementById("errorstock");
let errorfoto = document.getElementById("errorfoto");
let errortipoturbina = document.getElementById("errortipoturbina");
let errorsaltobruto = document.getElementById("errorsaltobruto");
let errornumgeneradores = document.getElementById("errornumgeneradores");
let errorpotencia = document.getElementById("errorpotencia");
let errortipo = document.getElementById("errortipo");
let erroridcentral = document.getElementById("erroridcentral");
let errordni= document.getElementById("errordni");
let errorapellidos= document.getElementById("errorapellidos");
let errorfechanac= document.getElementById("errorfechanac");
let erroremail= document.getElementById("erroremail");
let errorrolusu= document.getElementById("errorrolusu");
let erroridcategoria= document.getElementById("erroridcategoria");
let errorcoddepart= document.getElementById("errorcoddepart");
let errorclave = document.getElementById("errorclave");
let contador=0;
let alert = document.getElementById("alert");



setTimeout(function(){  alert.classList.remove("show");
}, 2000);

const validador = {
    cif:false,
    telefono:false,
    cp:false,
    dni:false,
    fechanac:false,
    email:false,
    potencia:false,
    saltobruto:false,  
    salariobase:false,
    horaextranormal:false,
    horaextranocturna:false,
    horaextrafestivo:false,
    nombre:false,
    direccion:false,
    constructor:false,
    provincia:false,
    poblacion:false,
    descripcion:false,
    marca:false,
    apellidos:false,
    foto:false,
    password:false
}

if(formulario.name=="usupas"){
    password.addEventListener("input", ()=>{
        if(password.validity.valid){
            errorclave.innerHTML="";
        }
    })
    
    // funcion valida formulario
const validarformulario=(event)=>{
    let valido=true;
    //valido nombre
    if(!password.validity.valid){
        event.preventDefault();
        if(password.validity.valueMissing){
            errorclave.innerHTML="La clave es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validatePasswordModerate(password.value.trim())){             
            event.preventDefault();              
                   errorclave.innerHTML="<ul class='listado'><li>Formato no valido.</li><li>Longitud mínima 8 carácteres</li><li>Debe contener al menos un número</li><li>Debe contener al menos una mayuscula</li></ul>";                    
        valido=false;
             }
    }
    
    if(valido && validador.password){
        formulario.submit();
    }
}
formulario.addEventListener("submit", validarformulario);
}

// caso departamentos 
//console.log(formulario.name);
if(formulario.name=="departamento"){
nombre.addEventListener("input", ()=>{
    if(nombre.validity.valid){
        errornombre.innerHTML="";
    }
    
})


// funcion valida formulario
const validarformulario=(event)=>{
    let valido=true;
    //valido nombre
    if(!nombre.validity.valid){
        event.preventDefault();
        if(nombre.validity.valueMissing){
            errornombre.innerHTML="El nombre es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspeciales(nombre.value.trim())){             
            event.preventDefault();              
                   errornombre.innerHTML="Formato no valido";                    
        valido=false;
             }
    }
    
    if(valido && validador.nombre){
        formulario.submit();
    }
}

formulario.addEventListener("submit", validarformulario);
}



// caso categorias 

if(formulario.name=="categoria"){
salariobase.addEventListener("input", ()=>{
    if(salariobase.validity.valid){
        errorsalariobase.innerHTML="";
    }
})

horaextranormal.addEventListener("input", ()=>{
    if(horaextranormal.validity.valid){
        errorhoraextranormal.innerHTML="";
    }
})

horaextranocturna.addEventListener("input", ()=>{
    if(horaextranocturna.validity.valid){
        errorhoraextranocturna.innerHTML="";
    }
})

horaextrafestivo.addEventListener("input", ()=>{
    if(horaextrafestivo.validity.valid){
        errorhoraextrafestivo.innerHTML="";
    }
})


// funcion valida formulario

const validarformulario=(event)=>{
    let valido=true;  
   
    if(!salariobase.validity.valid){
        event.preventDefault();
        if(salariobase.validity.valueMissing){
            errorsalariobase.innerHTML="El salario es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDecimal(salariobase.value.trim())){             
            event.preventDefault();              
                   errorsalariobase.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!horaextranormal.validity.valid){
        event.preventDefault();
        if(horaextranormal.validity.valueMissing){
            errorhoraextranormal.innerHTML="La hora extra normal es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDecimal(horaextranormal.value.trim())){             
            event.preventDefault();              
                   errorhoraextranormal.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!horaextranocturna.validity.valid){
        event.preventDefault();
        if(horaextranocturna.validity.valueMissing){
            errorhoraextranocturna.innerHTML="La hora extra nocturna es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDecimal(horaextranocturna.value.trim())){             
            event.preventDefault();              
                   errorhoraextranocturna.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!horaextrafestivo.validity.valid){
        event.preventDefault();
        if(horaextrafestivo.validity.valueMissing){
            errorhoraextrafestivo.innerHTML="La hora extra festivo es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDecimal(horaextrafestivo.value.trim())){             
            event.preventDefault();              
                   errorhoraextrafestivo.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
    if(valido && validador.salariobase && validador.horaextranormal && validador.horaextranocturna && validador.horaextrafestivo){
        formulario.submit();
    }
}

formulario.addEventListener("submit", validarformulario);
}


// caso proveedores

if(formulario.name=="proveedor"){
    
nombre.addEventListener("input", ()=>{
    if(nombre.validity.valid){
        errornombre.innerHTML="";
    }
})

cif.addEventListener("input", ()=>{
    if(cif.validity.valid){
        errorcif.innerHTML="";
    }
})

telefono.addEventListener("input", ()=>{
    if(telefono.validity.valid){
        errortelefono.innerHTML="";
    }
})

direccion.addEventListener("input", ()=>{
    if(direccion.validity.valid){
        errordireccion.innerHTML="";
    }
})

provincia.addEventListener("input", ()=>{
    if(provincia.validity.valid){
        errorprovincia.innerHTML="";
    }
})

poblacion.addEventListener("input", ()=>{
    if(poblacion.validity.valid){
        errorpoblacion.innerHTML="";
    }
})

cp.addEventListener("input", ()=>{
    if(cp.validity.valid){
        errorcp.innerHTML="";
    }
})

// funcion valida formulario

const validarformulario=(event)=>{
    let valido=true; 
  
    if(!nombre.validity.valid){
        event.preventDefault();
        if(nombre.validity.valueMissing){
            errornombre.innerHTML="El nombre es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspeciales(nombre.value.trim())){             
            event.preventDefault();              
                   errornombre.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!cif.validity.valid){
        event.preventDefault();
        if(cif.validity.valueMissing){
            errorcif.innerHTML="El CIF es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateCIF(cif.value.trim())){             
            event.preventDefault();              
                   errorcif.innerHTML="El CIF no es valido";
                    
        valido=false;
             }
    }
           
     if(!telefono.validity.valid){
        event.preventDefault();
        if(telefono.validity.valueMissing){
            errortelefono.innerHTML="El telefono es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateTelefono(telefono.value.trim())){             
            event.preventDefault();              
                   errortelefono.innerHTML="El teléfono no es valido";
                    
        valido=false;
             }
    }
    
      if(!direccion.validity.valid){
        event.preventDefault();
        if(direccion.validity.valueMissing){
            errordireccion.innerHTML="La direccion es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesDirDes(direccion.value.trim())){             
            event.preventDefault();              
                   errordireccion.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }

        if(!provincia.validity.valid){
        event.preventDefault();
        if(provincia.validity.valueMissing){
            errorprovincia.innerHTML="La provincia es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(provincia.value.trim())){             
            event.preventDefault();              
                   errorprovincia.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
        if(!poblacion.validity.valid){
        event.preventDefault();
        if(poblacion.validity.valueMissing){
            errorpoblacion.innerHTML="La poblacion es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(poblacion.value.trim())){             
            event.preventDefault();              
                   errorpoblacion.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
        
       if(!cp.validity.valid){
        event.preventDefault();
        if(cp.validity.valueMissing){
            errorcp.innerHTML="El código postal es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateCP(cp.value.trim())){             
            event.preventDefault();              
                   errorcp.innerHTML="El código postal no es valido";
                    
        valido=false;
             }
    }
    
    
    if(valido && validador.cif && validador.telefono && validador.cp && validador.nombre && validador.direccion && validador.provincia && validador.poblacion){
        formulario.submit();
    }
}

formulario.addEventListener("submit", validarformulario);
}

// caso productos

if(formulario.name=="producto"){
    
modelo.addEventListener("input", ()=>{
    if(modelo.validity.valid){
        errornombre.innerHTML="";
    }
})

descripcion.addEventListener("input", ()=>{
    if(descripcion.validity.valid){
        errordescripcion.innerHTML="";
    }
})

marca.addEventListener("input", ()=>{
    if(marca.validity.valid){
        errormarca.innerHTML="";
    }
})

stock.addEventListener("input", ()=>{
    if(stock.validity.valid){
        errorstock.innerHTML="";
    }
})



foto.addEventListener("input", ()=>{
    if(foto.validity.valid){
        errorfoto.innerHTML="";
    }
})


// funcion valida formulario

const validarformulario=(event)=>{
    let valido=true;
   
    if(!modelo.validity.valid){
        event.preventDefault();
        if(modelo.validity.valueMissing){
            errornombre.innerHTML="El nombre es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesDirDes(modelo.value.trim())){             
            event.preventDefault();              
                   errornombre.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!descripcion.validity.valid){
        event.preventDefault();
        if(descripcion.validity.valueMissing){
            errordescripcion.innerHTML="La descripcion es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesDirDes(descripcion.value.trim())){             
            event.preventDefault();              
                   errordescripcion.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!marca.validity.valid){
        event.preventDefault();
        if(marca.validity.valueMissing){
            errormarca.innerHTML="La marca es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspeciales(marca.value.trim())){             
            event.preventDefault();              
                   errormarca.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!stock.validity.valid){
        event.preventDefault();
        if(stock.validity.valueMissing){
            errorstock.innerHTML="El stock es obligatorio";
            valido=false;
        }
    }

 
    
        if(!foto.validity.valid){
        event.preventDefault();
        if(foto.validity.valueMissing){
            errorfoto.innerHTML="La foto es obligatoria";
            valido=false;
        }
    }  
   
    if(valido && validador.nombre && validador.descripcion && validador.marca && validador.foto){
        formulario.submit();
    }

}

formulario.addEventListener("submit", validarformulario);
}


// caso centrales

if(formulario.name=="central"){
    
nombre.addEventListener("input", ()=>{
    if(nombre.validity.valid){
        errornombre.innerHTML="";
    }
})

telefono.addEventListener("input", ()=>{
    if(telefono.validity.valid){
        errortelefono.innerHTML="";
    }
})

constructor.addEventListener("input", ()=>{
    if(constructor.validity.valid){
        errorconstructor.innerHTML="";
    }
})

provincia.addEventListener("input", ()=>{
    if(provincia.validity.valid){
        errorprovincia.innerHTML="";
    }
})

poblacion.addEventListener("input", ()=>{
    if(poblacion.validity.valid){
        errorpoblacion.innerHTML="";
    }
})

cp.addEventListener("input", ()=>{
    if(cp.validity.valid){
        errorcp.innerHTML="";
    }
})

tipoturbina.addEventListener("input", ()=>{
    if(tipoturbina.validity.valid){
        errortipoturbina.innerHTML="";
    }
})

saltobruto.addEventListener("input", ()=>{
    if(saltobruto.validity.valid){
        errorsaltobruto.innerHTML="";
    }
})

numgeneradores.addEventListener("input", ()=>{
    if(numgeneradores.validity.valid){
        errornumgeneradores.innerHTML="";
    }
})

potencia.addEventListener("input", ()=>{
    if(potencia.validity.valid){
        errorpotencia.innerHTML="";
    }
})

foto.addEventListener("input", ()=>{
    if(foto.validity.valid){
        errorfoto.innerHTML="";
    }
})


// funcion valida formulario

const validarformulario=(event)=>{
    let valido=true;
  
    if(!nombre.validity.valid){
        event.preventDefault();
        if(nombre.validity.valueMissing){
            errornombre.innerHTML="El nombre es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspeciales(nombre.value.trim())){             
            event.preventDefault();              
                   errornombre.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
   
      if(!telefono.validity.valid){
        event.preventDefault();
        if(telefono.validity.valueMissing){
            errortelefono.innerHTML="El telefono es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateTelefono(telefono.value.trim())){             
            event.preventDefault();              
                   errortelefono.innerHTML="El teléfono no es valido";
                    
        valido=false;
             }
    }
    
      if(!constructor.validity.valid){
        event.preventDefault();
        if(constructor.validity.valueMissing){
            errorconstructor.innerHTML="El constructor es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspeciales(constructor.value.trim())){             
            event.preventDefault();              
                   errorconstructor.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }

        if(!provincia.validity.valid){
        event.preventDefault();
        if(provincia.validity.valueMissing){
            errorprovincia.innerHTML="La provincia es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(provincia.value.trim())){             
            event.preventDefault();              
                   errorprovincia.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
        if(!poblacion.validity.valid){
        event.preventDefault();
        if(poblacion.validity.valueMissing){
            errorpoblacion.innerHTML="La poblacion es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(poblacion.value.trim())){             
            event.preventDefault();              
                   errorpoblacion.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!cp.validity.valid){
        event.preventDefault();
        if(cp.validity.valueMissing){
            errorcp.innerHTML="El código postal es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateCP(cp.value.trim())){             
            event.preventDefault();              
                   errorcp.innerHTML="El código postal no es valido";
                    
        valido=false;
             }
    }
           
           if(!tipoturbina.validity.valid){
        event.preventDefault();
        if(tipoturbina.validity.valueMissing){
            errortipoturbina.innerHTML="El tipo turbina es obligatorio";
            valido=false;
        }
    }
        
           if(!saltobruto.validity.valid){
        event.preventDefault();
        if(saltobruto.validity.valueMissing){
            errorsaltobruto.innerHTML="El salto bruto es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDecimal(saltobruto.value.trim())){             
            event.preventDefault();              
                   errorsaltobruto.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
    
           if(!numgeneradores.validity.valid){
        event.preventDefault();
        if(numgeneradores.validity.valueMissing){
            errornumgeneradores.innerHTML="Generadores son obligatorios";
            valido=false;
        }
    }
        
             if(!potencia.validity.valid){
        event.preventDefault();
        if(potencia.validity.valueMissing){
            errorpotencia.innerHTML="La potencia es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDecimal(potencia.value.trim())){             
            event.preventDefault();              
                   errorpotencia.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
           if(!foto.validity.valid){
        event.preventDefault();
        if(foto.validity.valueMissing){
            errorfoto.innerHTML="La foto es obligatoria";
            valido=false;
        }
    }
        
    if(valido && validador.telefono && validador.cp && validador.potencia && validador.nombre && validador.constructor && validador.provincia && validador.poblacion && validador.foto){
        formulario.submit();
    }
}

formulario.addEventListener("submit", validarformulario);
}

// caso almacenes

if(formulario.name=="almacen"){
    
tipo.addEventListener("input", ()=>{
    if(tipo.validity.valid){
        errortipo.innerHTML="";
    }
})

idcentral.addEventListener("input", ()=>{
    if(idcentral.validity.valid){
        erroridcentral.innerHTML="";
    }
})

// funcion valida formulario

const validarformulario=(event)=>{
    let valido=true;
  
    if(!tipo.validity.valid){
        event.preventDefault();
        if(tipo.validity.valueMissing){
            errortipo.innerHTML="El tipo es obligatorio";
            valido=false;
        }
    }
    
   
      if(!idcentral.validity.valid){
        event.preventDefault();
        if(idcentral.validity.valueMissing){
            erroridcentral.innerHTML="La central es obligatorio";
            valido=false;
        }
    }   
      
    if(valido){
        formulario.submit();
    }
}

formulario.addEventListener("submit", validarformulario);
}


// caso empleados


if(formulario.name=="empleado"){
    
dni.addEventListener("input", ()=>{
    if(dni.validity.valid){
        errordni.innerHTML="";
    }
})
    
nombre.addEventListener("input", ()=>{
    if(nombre.validity.valid){
        errornombre.innerHTML="";
    }
})

apellidos.addEventListener("input", ()=>{
    if(apellidos.validity.valid){
        errorapellidos.innerHTML="";
    }
})

fechanac.addEventListener("input", ()=>{
    if(fechanac.validity.valid){
        errorfechanac.innerHTML="";
    }
})

telefono.addEventListener("input", ()=>{
    if(telefono.validity.valid){
        errortelefono.innerHTML="";
    }
})

email.addEventListener("input", ()=>{
    if(email.validity.valid){
        erroremail.innerHTML="";
    }
})

direccion.addEventListener("input", ()=>{
    if(direccion.validity.valid){
        errordireccion.innerHTML="";
    }
})

provincia.addEventListener("input", ()=>{
    if(provincia.validity.valid){
        errorprovincia.innerHTML="";
    }
})

poblacion.addEventListener("input", ()=>{
    if(poblacion.validity.valid){
        errorpoblacion.innerHTML="";
    }
})

cp.addEventListener("input", ()=>{
    if(cp.validity.valid){
        errorcp.innerHTML="";
    }
})

rolusu.addEventListener("input", ()=>{
    if(rolusu.validity.valid){
        errorrolusu.innerHTML="";
    }
})

idcategoria.addEventListener("input", ()=>{
    if(idcategoria.validity.valid){
        erroridcategoria.innerHTML="";
    }
})

coddepart.addEventListener("input", ()=>{
    if(coddepart.validity.valid){
        errorcoddepart.innerHTML="";
    }
})

idcentral.addEventListener("input", ()=>{
    if(idcentral.validity.valid){
        erroridcentral.innerHTML="";
    }
})

foto.addEventListener("input", ()=>{
    if(foto.validity.valid){
        errorfoto.innerHTML="";
    }
})

// funcion valida formulario

const validarformulario=(event)=>{
    let valido=true;

 if(!dni.validity.valid){
        event.preventDefault();
        if(dni.validity.valueMissing){
            errordni.innerHTML="El DNI es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateDni(dni.value.trim())){             
            event.preventDefault();              
                   errordni.innerHTML="El DNI no es valido";
                    
        valido=false;
             }
    }   
   
    if(!nombre.validity.valid){
        event.preventDefault();
        if(nombre.validity.valueMissing){
            errornombre.innerHTML="El nombre es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(nombre.value.trim())){             
            event.preventDefault();              
                   errornombre.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
      if(!apellidos.validity.valid){
        event.preventDefault();
        if(apellidos.validity.valueMissing){
            errorapellidos.innerHTML="Los apellidos son obligatorios";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(apellidos.value.trim())){             
            event.preventDefault();              
                   errorapellidos.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }    
     
      if(!fechanac.validity.valid){
        event.preventDefault();
        if(fechanac.validity.valueMissing){
            errorfechanac.innerHTML="La fecha de nacimiento es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateFechanac(fechanac.value.trim())){             
            event.preventDefault();              
                   errorfechanac.innerHTML="La fecha no es valida";
                    
        valido=false;
             }
    }
    
      if(!telefono.validity.valid){
        event.preventDefault();
        if(telefono.validity.valueMissing){
            errortelefono.innerHTML="El telefono es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateTelefono(telefono.value.trim())){             
            event.preventDefault();              
                   errortelefono.innerHTML="El teléfono no es valido";
                    
        valido=false;
             }
    }
    
    if(!email.validity.valid){
        event.preventDefault();
        if(email.validity.valueMissing){
            erroremail.innerHTML="El email es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateEmail(email.value.trim())){             
            event.preventDefault();              
                   erroremail.innerHTML="El email no es valido";
                    
        valido=false;
             }
    }
    
      if(!direccion.validity.valid){
        event.preventDefault();
        if(direccion.validity.valueMissing){
            errordireccion.innerHTML="La direccion es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesDirDes(direccion.value.trim())){             
            event.preventDefault();              
                   errordireccion.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }

        if(!provincia.validity.valid){
        event.preventDefault();
        if(provincia.validity.valueMissing){
            errorprovincia.innerHTML="La provincia es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(provincia.value.trim())){             
            event.preventDefault();              
                   errorprovincia.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
        if(!poblacion.validity.valid){
        event.preventDefault();
        if(poblacion.validity.valueMissing){
            errorpoblacion.innerHTML="La poblacion es obligatoria";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateNoCaracteresEspecialesNiNumeros(poblacion.value.trim())){             
            event.preventDefault();              
                   errorpoblacion.innerHTML="Formato no valido";
                    
        valido=false;
             }
    }
    
    
       if(!cp.validity.valid){
        event.preventDefault();
        if(cp.validity.valueMissing){
            errorcp.innerHTML="El código postal es obligatorio";
            valido=false;
        }
    }else{//en el caso de que no haya errores de validity pero si de validate
            if(!validateCP(cp.value.trim())){             
            event.preventDefault();              
                   errorcp.innerHTML="El código postal no es valido";
                    
        valido=false;
             }
    }
    
        if(!rolusu.validity.valid){
        event.preventDefault();       
        if(rolusu.validity.valueMissing){
            errorrolusu.innerHTML="El rol usuario es obligatorio";
            valido=false;
        }
    }
    
        if(!idcategoria.validity.valid){
        event.preventDefault();
        if(idcategoria.validity.valueMissing){
            erroridcategoria.innerHTML="La categoria es obligatoria";
            valido=false;
        }
    }
    
    
        if(!coddepart.validity.valid){
        event.preventDefault();
        if(coddepart.validity.valueMissing){
            errorcoddepart.innerHTML="El departamento es obligatorio";
            valido=false;
        }
    }
    
        if(!idcentral.validity.valid){
        event.preventDefault();
        if(idcentral.validity.valueMissing){
            erroridcentral.innerHTML="La central es obligatoria";
            valido=false;
        }
    }
    
    
      if(!foto.validity.valid){
        event.preventDefault();
        if(foto.validity.valueMissing){
            errorfoto.innerHTML="La foto es obligatoria";
            valido=false;
        }
    }
    
    if(valido && validador.dni && validador.telefono && validador.cp && validador.fechanac && validador.email && validador.nombre && validador.apellidos && validador.direccion && validador.poblacion && validador.provincia && validador.foto){
        formulario.submit();
    }

}

formulario.addEventListener("submit", validarformulario);
}



function activa_boton(campo,boton){
	if (campo.value != "0"){
		boton.disabled=false;
         
	} else {
		boton.disabled=true;
	}
}




$( document ).ready(function() {
    $('#myModal').modal('toggle')
});


