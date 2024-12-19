package day11

import (
	"fmt"
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
	var c []Data
	cache, res := make(map[int][]int), 0
	for _, d := range wb {
		p := []Data{d}
		for len(p) != 0 {
			x, p = p[0], p[1:]
			cv, err := cache[x.number]
			if err {
				fmt.Printf("cache hit %v %v\n", x.number, cv)
				c = []Data{}
				if x.blinks > 0 {
					for _, r := range cv {
						c = append(c, Data{number: r, blinks: x.blinks-1})
					}
				}
			} else {
				c = process(x)
				tmp := []int{}
				for _, r := range c {
					if r.blinks > 0 {
						tmp = append(tmp, r.number)
					}
				}
				if len(tmp) > 0 {
					cache[x.number] = tmp;
				}
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
