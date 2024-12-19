package day11

import (
	"strconv"
)

type Data struct {
	number int
	blinks int
}

func process(d Data) (n []Data) {
	if d.blinks == 0 {
		return []Data{};
	}
	nb := d.blinks -1;

	if d.number == 0 {
		n = append(n, Data{number: 1, blinks: nb})
	} else {
		s := strconv.Itoa(d.number)
		if len(s) % 2 == 0 {
			h :=  len(s) / 2
			l, _ := strconv.Atoi(s[:h])
			r, _ := strconv.Atoi(s[h:])
			n = append(n, Data{number: l,blinks: nb}, Data{number: r, blinks: nb})
		} else {
			n = append(n, Data{number: d.number * 2024, blinks: nb})
		}
	}
	return
}

func Run(in []int, blinks int) int {
	var wb []Data
	for _, v := range in {
		wb = append(wb, Data{number: v, blinks: blinks})
	}

	var x Data
	cache, res := make(map[Data][]Data), 0
	for _, d := range wb {
		p := []Data{d}
		var c []Data
		for len(p) != 0 {
			x, p = p[0], p[1:]
			cv, err := cache[x]
			if err {
				c = cv
			} else {
				c = process(x)
				cache[x] = c
			}

			if len(c) == 0 {
				res ++
			} else {
				//fmt.Printf("C:%v\n", c)
				p = append(p, c...)
			}
		}
	}
	return res
}
