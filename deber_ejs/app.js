var express = require('express');
var app = express();
var path = require ('path');
app.set('view engine','ejs');


app.get('/about',function(req,res){
    res.render('pages/about'); 
});

app.get('/',function(req,res){
        var tagline = 'Empezando a utilizar EJS';
        var drinks=[
                        {name: 'Margarita', drunkness:3},
                        {name: 'Martini', drunkness:5},
                        {name: 'Fiesta en la Playa', drunkness:7}
        ];
    res.render('pages/index', {
        drinks: drinks,
        tagline: tagline   
    }); 
});



console.log("Staring web Server");
app.listen(4000);