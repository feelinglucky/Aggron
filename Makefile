all:
	ruhoh compile
	rsync -rv addition/ compiled/

clean:
	rm -rf compiled/*
