ruhoh: ./ruhoh/*
	cd ruhoh && make && cd -
	cp -Rf ./addition/* ./compiled/

clean:
	rm -rf compiled/*

archive: all
	7z a ./archives/`date +%Y-%m-%d`.7z ./ruhoh/compiled/*

publish: all
	cd tools && ./rsync-publish.csh && cd -

all: ruhoh

