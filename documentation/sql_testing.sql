--V1
SELECT e.id, e.name, e.cast, e.description, TIME_FORMAT(e.duration, "%H:%i"), e.picture, e.picture_text,
	g.id, g.name,
	l.id, l.name, l.link,
	p.id, p.date, p.time,
pb.id, pb.name, pb.price
FROM tbl_event e
LEFT JOIN tbl_genre g ON g.id = e.genre_id
LEFT JOIN tbl_link l ON l.event_id = e.id
LEFT JOIN tbl_performance p ON p.event_id = e.id
LEFT JOIN tbl_event_price ep ON ep.event_id = e.id
LEFT JOIN tbl_price_bracket pb ON pb.id = ep.price_bracket_id
ORDER BY p.date, p.time, e.name;

--Performance validation
SELECT e.name, TIME_FORMAT(e.duration, "%H:%i"), p.id, DATE_FORMAT(p.date, "%d.%m.%Y"), TIME_FORMAT(p.time, "%H:%i")
FROM tbl_performance p
LEFT JOIN tbl_event e ON e.id = p.event_id
WHERE p.date = "2014-12-22"
AND (("17:00:00" < p.time AND TIME(ADDTIME("17:00:00", "04:00:00")) > TIME(ADDTIME(p.time, e.duration)))
	OR "17:00:00" BETWEEN p.time AND TIME(ADDTIME(p.time, e.duration))
	OR TIME(ADDTIME("17:00:00", "04:00:00")) BETWEEN p.time AND TIME(ADDTIME(p.time, e.duration)))
ORDER BY p.date, p.time;

--Duration validation (only in edit)
--i need:
--	event_id
--	duration (new)
 --, ev.name, ev.duration, per.id, per.date, per.time
--SELECT cj.e_name, cj.p_date, cj.start, cj.end, cj.e_duration_old, ev.id
SELECT ev.name, TIME_FORMAT(ev.duration, "%H:%i"), per.id, DATE_FORMAT(per.date, "%d.%m.%Y"), TIME_FORMAT(per.time, "%H:%i")
FROM tbl_performance per
LEFT JOIN tbl_event ev ON ev.id = per.event_id
CROSS JOIN (
	SELECT e.name AS e_name, e.duration AS e_duration_old, p.id AS p_id, p.date AS p_date, p.time AS "start", TIME(ADDTIME(p.time, "06:00:00")) AS "end"
	FROM tbl_event e
	INNER JOIN tbl_performance p ON p.event_id = e.id
	WHERE e.id = 3
	ORDER BY p.date, p.time) cj
	
WHERE cj.p_date = per.date 
AND ((cj.start < per.time AND cj.end > TIME(ADDTIME(per.time, (CASE WHEN ev.id = 3 THEN "06:00:00" ELSE ev.duration END))))
	OR cj.start BETWEEN per.time AND TIME(ADDTIME(per.time, (CASE WHEN ev.id = 3 THEN "06:00:00" ELSE ev.duration END)))
	OR cj.end BETWEEN per.time AND TIME(ADDTIME(per.time, (CASE WHEN ev.id = 3 THEN "06:00:00" ELSE ev.duration END))))
AND per.id <> cj.p_id
ORDER BY per.date, per.time, ev.name; 
