DELIMITER $$
CREATE PROCEDURE getComicsWithValidatedChapter()
/* Cette procédure stockée renvoie la liste des comics avec au moins un chapitre validé */
BEGIN
	SELECT comics.*
	FROM comics
	WHERE comics.Id IN

	(
		SELECT narrativeArcs.comicId
		FROM narrativeArcs
		WHERE narrativeArcs.Id IN

		(
			SELECT volumes.narrativeArcId
			FROM volumes
			WHERE volumes.Id IN

			(
				SELECT chapters.volumeId
				FROM chapters
				WHERE chapters.Validated = 1
			)
		)
	);
END $$