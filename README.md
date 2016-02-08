# RegExp-API #

**RegExp-API** is a simple PHP API to form regular expressions

A bunch of chaining PHP functions to create Regular Expressions

## VERSION ##
0.2.0

## USAGE ##

    RegExpression::make('i', '/')->find('www')->optional('.')->also('google')->optional('.')->exclude('com');
