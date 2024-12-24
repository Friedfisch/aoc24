package day11

import (
	"strconv"
)

var cache map[string]int

func c(i, n int) string {
	return strconv.Itoa(i) + "_" + strconv.Itoa(n)
}

func process(number int, iter int) (r int) {
	if iter == 0 {
		return 1;
	}
	r, err := cache[c(iter, number)]
	if (err) {
		return
	}
	if number == 0 {
		r = process(1, iter - 1)
	} else {
		s := strconv.Itoa(number)
		if len(s) % 2 == 0 {
			h :=  len(s) / 2
			lv, _ := strconv.Atoi(s[:h])
			rv, _ := strconv.Atoi(s[h:])
			r = process(lv, iter - 1) + process(rv, iter - 1)
		} else {
			r = process(number * 2024, iter - 1)
		}
	}
	cache[c(iter, number)] = r
	return
}

func Run(in []int, blinks int) (r int) {
	cache = make(map[string]int)
	for _, d := range in {
		r += process(d, blinks)
	}
	return r
}
