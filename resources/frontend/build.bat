del ..\..\public\*.js;
del ..\..\public\*.css;
del ..\..\public\*.ico;
copy dist\frontend\*.js ..\..\public\;
copy dist\frontend\*.css ..\..\public\;
copy dist\frontend\*.ico ..\..\public\;
copy dist\frontend\index.html ..\views\index.html
