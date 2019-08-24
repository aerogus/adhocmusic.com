exports.config =
  paths:
    watched: ['app']
  files:
    stylesheets:
      joinTo:
        'css/adhoc.css': /^app\/styles\/adhoc.styl/
        'css/concours-ou-est-pidou.css': /^app\/styles\/concours-ou-est-pidou.styl/
  plugins:
    # à n'exécuter qu'une fois
    afterBrunch: [
      #'unlink ./public/media && ln -s ../media ./public/media',
      #'unlink ./public/img/cache && ln -s ../../cache/img ./public/img/cache'
    ]
    postcss:
      options:
        relative: true
      processors: [
        # permet inline() en css
        require('postcss-assets')
        require('autoprefixer')(['last 3 versions'])
      ]

