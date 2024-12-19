package day11_test

import (
	"testing"

	day11 "github.com/Friedfisch/aoc24/11"
)

func TestRunTest(t *testing.T) {
	blinks, expected, in := 25, 55312, []int{125, 17}
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
	//t.Fail()
}

/*
func TestRunData25(t *testing.T) {
	blinks, expected, in := 25, 189092, []int{0, 5601550, 3914, 852, 50706, 68, 6, 645371}
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
	//t.Fail()
}

func TestRunData0_50(t *testing.T) {
	return;
	// 663251546
	blinks, expected, in := 50, 0, []int{0} // 88sec
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
	t.Fail()
}
*/
func TestRunData0_75(t *testing.T) {
	blinks, expected, in := 75, 0, []int{0}//, 5601550, 3914, 852, 50706, 68, 6, 645371} // ??
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
	t.Fail()
}
/*
func TestRunDataAll_75(t *testing.T) {
	/*t.SkipNow()
	blinks, expected, in := 75, 0, []int{0, 5601550, 3914, 852, 50706, 68, 6, 645371} // ??
	res := day11.Run(in, blinks)
	t.Logf("Res: %v\n", res)
	if res != expected {
		t.Fatalf("Result wrong R: %d, E: %d", res, expected)
	}
	t.Fail()
}
*/
