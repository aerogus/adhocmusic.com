exports.config =
  conventions:
      assets: /^app\/assets\//
  paths:
    public: 'public-beta'
  modules:
    definition: false
    wrapper: false
  files:
    javascripts:
      joinTo:
        'js/app.js': /^app/
        'js/vendor.js': /^bower_components|vendor/
    stylesheets:
      joinTo:
        'css/app.css': /^app\/styles/
        'css/vendor.css': /^bower_components|vendor/
  plugins:
    jaded:
      staticPatterns: /^app(\/|\\)views(\/|\\)(.+)\.jade$/
