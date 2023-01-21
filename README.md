# Letter Boxed

This is a Symfony console application to help solve the NYTimes [Letter Boxed](https://www.nytimes.com/puzzles/letter-boxed) word game.

Letter Boxed is a word game where you create words from letters in a square grid. Words must be at least 3 letters in length, letters can be reused, and consecutive letters must not come from the same side. The last letter of a word becomes the first letter of the next word. The aim is to use all letters to solve the puzzle in as few words as possible.

This console application accepts a list of one or more words, validates that they follow the rules of the game, then returns any letters that haven’t yet been used by the given words.

For example, the January 19, 2023 puzzle had these letters:

* XBM
* INA
* OYL
* TEC

If we feed the word “exclamation” into the application, it should return the letters “BY”, since those are the only letters left that haven’t been used in the provided word.

This application has been written with the help of GPT-3 as a proof of concept.
