
var fb = {

  formataDinheiroBR:function(val){
      return  val.toLocaleString('pt-BR', { minimumFractionDigits: 2});
  },

  formataDinheiroUSA:function(val){  
      if(val === 0 ){
        return val;
      }
      return parseFloat(val.split(".").join("").replace(",","."));   
  },

  injecthtml:function(html,el){
    document.getElementById(el).innerHTML = html;  
  },


  isvalid:function(item){
    for (let x in item) {
      let i = jv.qs(item[x]);
      if(!i){
      return Swal.fire(
            'Ops ....!',
            'Parece que esse Campo esta Vazio!<hr><br>Campo: <u><b>'+item[x]+'</b></u>',
            'warning'
          ),false
      }
    }
    return true;
  },
  isvalid2:function(item){
    for (let x in item) {
      if(!item[x]){
      return Swal.fire(
            'Ops ....!',
            'Parece que esse Campo esta Vazio!<hr><br>Campo: <u><b>'+x+'</b></u>',
            'warning'
          ),false
      }
    }
    return true;
  },

  insert:function(el,val){
    return document.querySelector('.'+el).value = val;
  },

  suporte:function(){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Oops Desculpe algo não saiu como planejado Contate o suporte Tecnico!',
    })
  },

  maskDim:function(mas){ //recebe array de class para ponhar mask de dinheiro
    for (let x in mas) {
      let dim = '.'+mas[x]; 
      VMasker(document.querySelector(dim)).maskMoney();
    }
  },

  qsof:function(parms){
    return document.querySelectorAll('.'+parms);
  },

  qs:function(parms){
     return document.querySelector('.'+parms).value;
  },

  qsf:function(parms){
    return document.querySelector('.'+parms).files[0];
  },

  byIdSoma:function(parms){
    let res = document.getElementById(parms).value;
    return (res)?res:0;
  },

  isvalidTeF:function(item){
    for (let x in item) {
      if(!item[x]){
        return false;
      }
    }
    return true;
  },
  ID:function(){
      // Math.random deve ser único por causa de seu algoritmo de propagação.
      // Converta para a base 36 (números + letras) e pegue os primeiros 9 caracteres
      // após o decimal.
      return  Date.now().toString( 36 ).substr ( 2 ,  9 );
     
  },
  byID:function(parm,res){
    if(res){
      return document.getElementById(parm).value;
    }else{
      return document.getElementById(parm);
    }

    
  },

  limpaCampos:function() {
      var elements = document.getElementsByName("form_txt");
      elements.forEach(element => {
        console.log(element);
        element.value = '';
      })
  },

  formData:function(args){//recebe json
     var data = new FormData();
     for(let x in args){
       data.append(x,args[x]);
     }
     return data;
  },
  Ajax:async function(method,parms,url){
    if(['POST','PUT'].indexOf(method)+1){
      if(parms){
        var req = await fetch(base+url,{
          method:method,
          header:new Headers({'Content-Type':'application/json'}),
          body:parms
        });
      }else{
        var req = await fetch(base+url,{
          method:method,
          header:new Headers({'Content-Type':'application/json'}),
        });
      }
      let res = await req.json();
      return res;
    }else{
       if(parms){
          var req = await fetch(base+url+ new URLSearchParams({
            parms
          }))
       }else{
          var req = await fetch(base+url);
       }
      
       let res = await req.json();
       return res;
    }
    
  }

}  


    
window.addEventListener('load', function() {
  listar();
})

var tipo = '';
var page = 0;

function setTipo(v){
   tipo = v;
   let qt = fb.qsof('tt');
   for (let index = 0; index <= qt.length; index++) {
       if(!index){
        qt[index].innerHTML = tipo
       } 
   }
}

function setPage(v){
   page = v;
}

async function pesquisa(str){
  listar(page,str);
} 



async function deleteDev(id,obj){
  Swal.fire({
     title: 'Tem Certeza?',
     text: "Esse Dev sera Deletado!",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Sim, delete!'
   }).then((result) => {
     if (result.isConfirmed) {
        let trpai = obj.parentNode.parentNode;
        let res = fb.Ajax('DELETE',false,'developers/'+id);
        if(res){
          $(trpai).hide(200);
          Swal.fire(
           'Deleted!',
           'Dev foi deleted.',
           'success'
          )
          listar(0);
        }else{
           fb.suporte();
        }
       
     }
  })
  
}

async function getInfoDev(id){
   var res = await fb.Ajax('GET',false,'developer/'+id);
   if(res){
      fb.insert('nome',res.nome);
      fb.insert('sexo',res.sexo);
      fb.insert('idade',res.idade);
      fb.insert('hobby',res.hobby);
      fb.insert('data_nascimento',res.data_nascimento);
      fb.insert('edi',res.id);
   }
}

async function add_ou_edit(){
   let nome = fb.qs('nome');
   let sexo = fb.qs('sexo');
   let idade = fb.qs('idade');
   let hobby = fb.qs('hobby');
   let data_nascimento = fb.qs('data_nascimento');
   let id = (fb.qs('edi')) ? fb.qs('edi'): 'null';
   let msg = (tipo == "Adicionar DEV") ? 'Dev Adicionado com sucesso' : 'Edição realizada com sucesso' ;
   let url = (tipo == "Adicionar DEV") ? 'developers' : 'developers/'+id ;
   if(fb.isvalid2({nome, idade, sexo, hobby, data_nascimento })){
      let dados = fb.formData({nome, idade, sexo, hobby, data_nascimento,id});
      let res = await fb.Ajax('POST',dados,url);
      if(res){
         Swal.fire(msg,'','success');
         fb.limpaCampos();
         myModal.hide();
         listar(0);
      }else{
         fb.suporte();
      }

   }
   
}

async function listar(page = '',pesquisa = ''){
  let dados = await fb.Ajax('GET', null,'developers?page='+page+'&pesquisa='+pesquisa);
  let html = '';
  let html2 = '';
  //
     if (dados.dados.length > 0){
       for (let x in dados.dados) {
         html+= `
         <tr>
           <th>`+dados.dados[x].id+`</th>
           <td>`+dados.dados[x].nome+`</td></td>
           <td>`+dados.dados[x].sexo+`</td>
           <td>`+dados.dados[x].idade+`</td>
           <td>`+dados.dados[x].hobby+`</td>
           <td>`+dados.dados[x].data_nascimento+`</td>
           <td>
                <img class='btn btn-warning m-1' data-bs-toggle='modal' onclick='getInfoDev("`+dados.dados[x].id+`");setTipo("Edita DEV");' data-bs-target='#staticBackdrop3' src='`+base2+`src/css/icons/pencil-square.svg' alt='ops'>
                <img class='btn btn-danger m-1 ' src='`+base2+`/src/css/icons/trash.svg' alt='ops'  onclick='deleteDev("`+dados.dados[x].id+`",this)' >
           </td>
         </tr>
         `;
       }
       
       for(let x = 0; x < dados.pageCount; x++){
         html2+= `<li class="page-item">
             <a class="page-link" onclick="listar(`+x+`);setPage(`+x+`)">`+(x+1)+`</a>
         </li>`;
       }

       fb.injecthtml(html, 'lista');
       fb.injecthtml(html2, 'pagination');
     }
 }




