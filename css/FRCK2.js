var host = getUrlParam('h');
if (host) {
  document.getElementById('host').innerText = host;
}

function getUrlParam(name) {
  var search = window.location.search;
  if (search !== '') {
    var reg = new RegExp('(?:[?&]' + name + '=)([^&$]*)', 'i');
    var r = search.substr(1).match(reg);
    if (r !== null) {
      return unescape(r[1]);
    }
  }
  return '';
}