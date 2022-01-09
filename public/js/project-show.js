(async function () {
    const articleId = getProjectId()
    const articleData = await getProjectData(projectId)
    displayProject(projectData)
  })()
  
  function getProjectId() {
    return new URL(location.href).searchParams.get('id')
  }
  
  function getProjectData(projectId) {
    return fetch("https://jsonplaceholder.typicode.com/posts/" + projectId)
      .then(function(httpBodyResponse) {
        return httpBodyResponse.json()
      })
      .then(function(project) {
        return project
      })
      .catch(function(error) {
        alert(error)
      })
  }
  
  function displayArticle(projectData) {
    document.getElementById("blog__title").textContent = projectData.title
    document.getElementById("blog__body").textContent = projectData.body
  }