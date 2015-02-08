ALTER TABLE tag ADD COLUMN counter int(11) UNSIGNED;

UPDATE tag t SET counter = (

  SELECT count(p.id)
  FROM picture_tag pt
  JOIN picture p ON p.id = pt.picture_id
  WHERE pt.tag_id = t.id
  GROUP BY t.id

);

/*WHERE t.title = '2007';*/

DELETE FROM tag WHERE title LIKE 'IMG_%';