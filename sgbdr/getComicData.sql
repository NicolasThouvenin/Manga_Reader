DELIMITER $$
CREATE PROCEDURE getComicData(IN inComicId INTEGER)
/* Cette procédure retourne un JSON avec les informations d'un comic :
	- Id
	- Titre
	- Auteur
	- Genres: sous forme d'une chaine concaténées des Id de genre
	- Synopsie
	- Arborescence Arc, Tome, Chapitre avec leurs dates
 */
BEGIN
	SELECT comics.Id, comics.Title, comics.Synopsie, comics.StartDate, comics.EndDate, comics.CoverExt, filteredUsers.Login, filteredUsers.Firstname, filteredUsers.Surname, GROUP_CONCAT(searchComics.genreId), narrativeArcsData.data
	FROM comics
	JOIN (
	    	SELECT users.Login, users.Firstname, users.Surname, authors.comicId 
	    	FROM users
	    	JOIN authors
	    	ON users.Id = authors.userId
		) AS filteredUsers
	ON filteredUsers.comicId = comics.Id
	JOIN
	searchComics
	ON comics.Id = searchComics.comicId
	JOIN (
			SELECT n.comicId, CONCAT('{', 'number:', n.Number, ',title:"', n.Title, '",synopsie:"', n.Synopsie, '",startDate:"', CAST(n.StartDate AS CHAR), '",endDate:"', IF(n.EndDate, CAST(n.EndDate AS CHAR), ''), '",volumes:', volumesData.data, '}') as data
			FROM narrativeArcs AS n
			JOIN (
				SELECT v.narrativeArcId, CONCAT('{', 'number:', v.Number, ',title:"', v.Title, '",synopsie:"', v.Synopsie, '",startDate:"', CAST(v.StartDate AS CHAR), '",endDate:"', IF(v.EndDate, CAST(v.EndDate AS CHAR), ''), '"}') as data
				FROM volumes AS v
				) AS volumesData
			ON volumesData.narrativeArcId = n.Id
		) AS narrativeArcsData
	ON narrativeArcsData.comicId = comics.Id
	GROUP BY comics.Id;
END $$


CAST(v.EndDate AS CHAR)


IF(v.EndDate, CAST(v.EndDate AS CHAR), '')