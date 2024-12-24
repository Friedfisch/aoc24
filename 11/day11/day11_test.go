package day11_test

import (
	"testing"

	"github.com/Friedfisch/aoc24/11/day11"
)

func TestRunData1(t *testing.T) {
	blinks, expected, in := 1, 1, []int{0}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData2(t *testing.T) {
	blinks, expected, in := 2, 1, []int{0}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData3(t *testing.T) {
	blinks, expected, in := 3, 2, []int{0}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData4(t *testing.T) {
	blinks, expected, in := 4, 4, []int{0}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData5(t *testing.T) {
	blinks, expected, in := 5, 4, []int{0}
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData6(t *testing.T) {
	blinks, expected, in := 6, 7, []int{0}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

/*
0: 0
1: 1
2: 2024
3: 20 24
4: 2 0 2 4
5: 4048 1 4048 8096
6: 40 48 2024 40 48 80 96
7: 4 0 4 8 20 24 4 0 4 8 8 0 9 6
*/
func TestRunData7(t *testing.T) {
	blinks, expected, in := 7, 14, []int{0}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunTest(t *testing.T) {
	blinks, expected, in := 25, 55312, []int{125, 17}
	res := day11.Run(in, blinks)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}


func TestRunData25(t *testing.T) {
	blinks, expected, in := 25, 189092, []int{0, 5601550, 3914, 852, 50706, 68, 6, 645371}
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData0_50(t *testing.T) {
	blinks, expected, in := 50, 663251546, []int{0} // 88sec
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}

func TestRunData0_75(t *testing.T) {
	blinks, expected, in := 75, 224869647102559, []int{0, 5601550, 3914, 852, 50706, 68, 6, 645371} // ??
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
}
