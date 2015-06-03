exports.config =
  paths:
    public: 'public'
  files:
    javascripts:
      joinTo:
        'js/adhoc.js': /^app/
        'js/vendor.js': /^bower_components/
    stylesheets:
      joinTo:
        'css/adhoc.css': /^app\/styles/
