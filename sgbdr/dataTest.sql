INSERT INTO genres (Label) VALUES ('Action'), ('Adventure'), ('Comedy'), ('Drama'), ('Fantasy'), ('Historical'), ('Horror'), ('Sci-fi');

CALL createUser('toto', 'toto', 'Du marché', '2015-11-11', '1234', 'toto@toto.fr', @userID);


CALL createComic('Voyage au bout du bout', 'Un gars avec un baton et un cochon qui parle', '2015-02-02', 1, 'jpg', @newComic);

INSERT INTO comicsgenres (genreId, comicId) VALUES (1, 1), (2, 1), (3, 1), (5, 1);

CALL createVolume('Le très méchant Tutu', 'Le gars et le cochon doivent détruire les armées du méchant Tutu', '2018-07-31', 1, @lastVolume);

CALL createChapter('Tutu et le vilage maudit', 'Tutu a jeté un sort sur le village', 1, @lastChapter);
CALL createComicStrip(1, 'jpg', 1, @id);
CALL createComicStrip(2, 'jpg', 1, @id);
CALL createComicStrip(3, 'jpg', 1, @id);
CALL createComicStrip(4, 'jpg', 1, @id);

CALL createChapter('La fin du sortilège', 'Tutu a jeté un sort sur le village', 2, @lastChapter);
CALL createComicStrip(1, 'jpg', 2, @id);
CALL createComicStrip(2, 'jpg', 2, @id);
CALL createComicStrip(3, 'jpg', 2, @id);
CALL createComicStrip(4, 'jpg', 2, @id);

CALL createVolume('La grande méchante Tata', 'Le gars aidé du cochon doivent combatte Tata la sorcière', '2018-08-31', 1, @lastVolume);

CALL createChapter('Les chutes d''eau', 'Il tombe à l''eau', 3, @lastChapter);

CALL createChapter('Les grands magasins', 'Il s''achète une robe', 4, @lastChapter);