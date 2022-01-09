(async function() {
    const projects = await getProjects()
    
    for (project of projects) {
      displayProject(project)
    }
  })()
  
  function getProjects() {
    return fetch("http://localhost:8000/api/v1/projects")
      .then(function(httpBodyResponse) {
        return httpBodyResponse.json()
      })
      .then(function(projects) {
        return projects
      })
      .catch(function(error) {
        alert(error)
      })
  }
  
  function displayProject(project) {
    const templateElt = document.getElementById("templateArticle")
    const cloneElt = document.importNode(templateElt.content, true)
  
    cloneElt.getElementById("blog__title").textContent = project.title
    cloneElt.getElementById("blog__body").textContent = project.body
    cloneElt.getElementById("blog__link").href += "?id=" + project.id
  
    document.getElementById("main").appendChild(cloneElt)
  }