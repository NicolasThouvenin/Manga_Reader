INSERT INTO users (Login, Firstname, Surname, BirthDate, Email, EmailValided) VALUES ('toto', 'toto', 'au marché', '2015-11-11', 'toto@toto.fr', 1);

INSERT INTO comics (Title, Synopsie, StartDate) VALUES ('Voyage au bout du bout', 'Un gars avec un baton et un cochon qui parle', NOW());

INSERT INTO authors (comicId, userId) VALUES (1,1);

INSERT INTO genre (Label) VALUES ('Action'), ('Adventure'), ('Comedy'), ('Drama'), ('Fantasy'), ('Historical'), ('Horror'), ('Sci-fi');

INSERT INTO searchComics (genreId, comicId) VALUES (1, 1), (2, 1), (3, 1), (5, 1);

INSERT INTO narrativeArcs (Title, Number, Synopsie, StartDate, comicId) VALUES ('Le voyage vers l''Ouest', 1, 'Un gars rencontre un cochon et part vers l''Ouest', '2018-07-31', 1);

INSERT INTO volumes (Title, Number, Synopsie, StartDate, narrativeArcId) VALUES ('Le très méchant Tutu', 1, 'Le gars et le cochon doivent détruire les armées du méchant Tutu', '2018-07-31', 1);

INSERT INTO chapters (Title, Number, Synopsie, Validated, volumeId) VALUES ('La rencontre', 1, 'Le gars rencontre le cochon', 0, 1);
