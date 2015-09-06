exports.config =

  paths:
    watched: ['app']

  modules:
    definition: false
    wrapper: false

  files:
    stylesheets:
      joinTo:
        'css/adhoc.css': /^app\/styles\/adhoc.styl/
