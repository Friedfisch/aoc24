package main

import (
	"fmt"

	"github.com/Friedfisch/aoc24/11/day11"
)

func main() {
	//blinks, expected, in := 75, 0, []int{0}//, 5601550, 3914, 852, 50706, 68, 6, 645371} // ??
	//blinks, expected, in := 25, 189092, []int{0, 5601550, 3914, 852, 50706, 68, 6, 645371} // ??
	blinks, expected, in := 25, 189092, []int{0, 5601550, 3914, 852, 50706, 68, 6, 645371} // ??
	res := day11.Run(in, blinks)
	fmt.Printf("Res: %v\n", res)
	if res != expected {
		fmt.Printf("Result wrong R: %d, E: %d\n", res, expected)
	}
}
