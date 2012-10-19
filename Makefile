all:
	ruhoh compile
	rsync -r addition/ compiled/

clean:
	rm -rf compiled/*
