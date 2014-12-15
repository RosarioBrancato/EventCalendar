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

--V2
SELECT e.id, e.name, e.duration, p.id, p.date, p.time
FROM tbl_performance p
LEFT JOIN tbl_event e ON e.id = p.event_id
WHERE "2014-12-17" = p.date 
AND ("09:10:00" BETWEEN p.time AND ADDTIME(p.time, e.duration)
OR ADDTIME("09:10:00", "02:00:00") BETWEEN p.time AND ADDTIME(p.time, e.duration))
ORDER BY p.date, p.time;
