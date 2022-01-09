function project(event){
    event.preventDefault();
   
    const url = this.href;
    
   const title = this.querySelector('div.modal-title');

    axios.get(url).then(function(response){

        this.data.title = response.data.title;
    
        //const title = response.data.title;
        //title.textContent = title;
       //spanCount.textContent = response.data.test;
       
        console.log(response);
    })
   }
   
   document.querySelectorAll('a.js-detail').forEach(function(link){
       link.addEventListener('click', project)
   })

