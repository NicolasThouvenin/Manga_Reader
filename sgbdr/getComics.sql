DELIMITER $$
CREATE PROCEDURE getComicsWithValidedChapter(IN inComicId INTEGER)
/* Cette procédure stockée renvoie la liste des comics avec au moins un chapitre validé */
BEGIN

	SELECT comics.*
	FROM comics
	WHERE comics.Id IN

	(
		SELECT DISTINCT narrativeArcs.comicId
		FROM narrativeArcs
		WHERE narrativeArcs.Id IN

		(
			SELECT DISTINCT volumes.narrativeArcId
			FROM volumes
			WHERE volumes.Id IN

			(
				SELECT DISTINCT chapters.volumeId
				FROM chapters
				WHERE chapters.Validated = 1
			)
		)

	);

END $$