all:
	ruhoh compile
	rsync -r addition/ compiled/

publish:
	cd tools && ./rsync-publish.csh && cd -

clean:
	rm -rf compiled/*
