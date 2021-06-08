const puppeteer = require('puppeteer');
const mysql = require('mysql');
let empty = require('is-empty');
const db = mysql.createConnection({

    host: "localhost",

    user: "root",

    password: "",

    database: "pornhub",

    charset : 'utf8'
});

(async () => {
    const browser = await puppeteer.launch({headless : true});
    const page = await browser.newPage();
    await page.setDefaultNavigationTimeout(0);
    await page.goto('https://fr.pornhub.com/categories?o=al');
    const categories = await page.evaluate(() => {
        let categories = [];
        let elements = document.querySelectorAll('div.category-wrapper');

        for (element of elements){
            categories.push({
                title: element.querySelector('strong').textContent,
                link : element.querySelector('a').href,
                picture : element.querySelector('img').dataset.thumb_url
            })
        }
        return categories;
    })
    for (categorie of categories){
        let title = categorie['title'];
        let link = categorie['link'];
        let picture = categorie['picture'];
        let verif = db.query("SELECT title FROM categories WHERE title = '"+title+"'");

        if (empty(verif)) {
            db.query("INSERT INTO categories(title, link, picture) VALUES ('" + title + "','" + link + "','" + picture + "')")
        }
    }

    await browser.close();
})
();

(async () => {
    const browser = await puppeteer.launch({headless : false});
    const page = await browser.newPage();
    let porn = [];
    for (let compteur=1747; compteur<=1754; compteur++) {
        await page.goto('https://fr.pornhub.com/pornstars?t=a&page='+compteur+'');
        const pornstars = await page.evaluate(() => {
            let reponses = [];
            let elements = document.querySelectorAll('#popularPornstars > li > div.wrap');
            for (element of elements){
                let video = element.querySelector('div.thumbnail-info-wrapper > span').textContent;
                let videos = video.split(' ');
                let name = element.querySelector('a').dataset.mxptext;
                if(name.includes('"')){
                    name = name.toString().replace('"', "'");
                    if(name.includes('"')) {
                        name = name.toString().replace('"', "'");
                    }
                }
                reponses.push({
                    rank : element.querySelector('a > span > span > span.rank_number').textContent.trim(),
                    name: name,
                    link : element.querySelector('a').href,
                    number_video : videos[0],
                    picture : element.querySelector('a img').dataset.thumb_url,
                })
            }
            return reponses;
        })
        for (reponses of pornstars){
            let name = reponses['name'];
            let link = reponses['link'];
            let videos_number = reponses['number_video'];
            let picture = reponses['picture'];
            let rank =reponses['rank'];
            if (empty(rank)){
                rank=1;
            }
            db.query('INSERT INTO pornstars(rank, name, link, videos_number, picture) VALUES ("'+rank+'","'+name+'","'+link+'","'+videos_number+'","'+picture+'")')
        }
        porn.push(compteur);
    }
    console.log(porn);
    await browser.close();
})

();

 (async () => {
    const browser = await puppeteer.launch({headless : true});
    const page = await browser.newPage();

    let categories = []
    for (let compteur=753; compteur<=2273; compteur++) {
        await page.goto('https://fr.pornhub.com/video?o=mv&t=a&cc=fr&page='+compteur+'');
        const infos = await page.evaluate(() => {
            let videos = [];
            let elements = document.querySelectorAll('div.wrap');
            let compteur2 = 0;
            for (element of elements) {
                if(compteur2 > 5) {
                    let link = element.querySelector('a').href;
                    let title = element.querySelector('span a').title;
                    let picture = element.querySelector('img').dataset.thumb_url;
                    let duration = element.querySelector('var').textContent;
                    videos.push({
                        title: title,
                        picture: picture,
                        link: link,
                        duration: duration,
                    })
                }
                compteur2++;
            }
            return videos;
        })
        let link
        let title
        let picture
        let duration
        for (info of infos){
            link = info['link'];
            title = info['title'];
            picture = info['picture'];
            duration = info['duration'];

            const page2 = await browser.newPage();
            await page2.goto(link);
            const video = await page2.evaluate(() => {
                    let infos2 = [];
                    let elements = document.querySelector('div.video-wrapper:nth-child(1)');
                    if (elements) {
                        let views = elements.querySelector('div.video-actions-menu > div.ratingInfo > div.views > span').textContent;
                        let likes = elements.querySelector('div.video-actions-menu > div.votes-fav-wrap > div.js-voteUp.icon-wrapper.tooltipTrig > span').textContent;
                        let dislikes = elements.querySelector('div.video-actions-menu > div.votes-fav-wrap > div.js-voteDown.icon-wrapper.tooltipTrig > span').textContent;
                        let likePourcent = parseFloat(elements.querySelector('div.video-actions-menu > div.ratingInfo > div.ratingPercent > span').textContent);
                        let channel_name;
                        try {
                            channel_name = document.querySelector('div.video-actions-container > div.video-actions-tabs > div.video-action-tab.about-tab.active > div.video-detailed-info > div.video-info-row.userRow > div.userInfo > div > span > a').text;
                        } catch (error) {
                            channel_name = document.querySelector('div.video-actions-container > div.video-actions-tabs > div.video-action-tab.about-tab.active > div.video-detailed-info > div.video-info-row.userRow > div.userInfo > div  > a').text;
                        }

                        let pornstar = document.querySelectorAll('div > div:nth-child(1) > div.video-actions-container > div.video-actions-tabs > div.video-action-tab.about-tab.active > div.video-detailed-info > div > div.pornstarsWrapper.js-pornstarsWrapper > a');
                        let pornstars;
                        let pLength = pornstar.length;
                        let compteur = 0;
                        if (pLength > 1) {
                            for (porn of pornstar) {
                                let plink = porn.href
                                let pname = porn.textContent.trim();
                                if (compteur === 0) {
                                    pornstars = pname;
                                } else {
                                    pornstars = pornstars + "|" + pname;
                                }
                                compteur++;
                            }
                        } else {
                            pornstars = "Nothing";
                        }

                        let categorie = document.querySelectorAll('div.categoriesWrapper a');
                        let categories;
                        let cLength = categorie.length;
                        if (cLength > 1) {
                            let compteur1 = 0;
                            for (categori of categorie) {
                                let cname = categori.textContent.trim();
                                if (compteur1 === 0) {
                                    categories = cname;
                                } else {
                                    if (cname !== 'Proposer') {
                                        categories = categories + "|" + cname;
                                    }
                                }
                                compteur1++;
                            }
                        } else {
                            categories = "Nothin"
                        }

                        let tag = document.querySelectorAll('div.tagsWrapper a');
                        let tags;
                        let tLength = tag.length;
                        if (tLength > 1) {
                            let compteur2 = 0;
                            for (ta of tag) {
                                let tname = ta.textContent.trim();

                                if (compteur2 === 0) {
                                    tags = tname;
                                } else {
                                    if (tname !== 'Proposer') {
                                        tags = tags + "|" + tname;
                                    }
                                }
                                compteur2++;
                            }

                        } else {
                            tags = "Nothing";
                        }


                        infos2.push({
                            views: views,
                            likes: likes,
                            dislikes: dislikes,
                            likePourcent: likePourcent,
                            channel_name: channel_name,
                            categories: categories,
                            pornstars: pornstars,
                            tags: tags,
                        })
                        return infos2;
                    }
                }
            )
            if (video) {
                await sleep(1000)
                const span = await page2.$('#jsShare');
                await span.evaluate(span => span.click());

                const div = await page2.$('#hd-leftColVideoPage > div> div.video-actions-container > div.video-actions-tabs > div.video-action-tab.share-tab.active > div.video-actions-sub-menu > div:nth-child(3)');
                await div.evaluate(div => div.click());

                const iframe = await page2.evaluate(() => {
                    let frame
                    try {
                        frame = document.querySelector('#js-tabData > div.video-action-sub-tab.embed.active > textarea').textContent
                    }catch (e) {
                        sleep(1000)
                        frame = document.querySelector('#js-tabData > div.video-action-sub-tab.embed.active > textarea').textContent
                    }
                    return frame;
                })
                let videos = [];
                let frame = iframe;
                for (vid of video) {
                    title
                    link
                    picture
                    duration
                    let views = vid['views']
                    let likes = vid['likes']
                    let dislikes = vid['dislikes']
                    let likePourcent = vid['likePourcent']
                    let channel = vid['channel_name']
                    let categories = vid['categories']
                    let pornstars = vid['pornstars']
                    let tags = vid['tags']
                    if (frame.includes('"')) {
                        while (frame.includes('"')) {
                            frame = frame.toString().replace('"', "'");
                        }
                    }
                    if (title.includes('"')) {
                        while (title.includes('"')) {
                            title = title.toString().replace('"', "'");
                        }
                    }
                    if (channel.includes('"')) {
                        while (channel.includes('"')) {
                            channel = channel.toString().replace('"', "'");
                        }
                    }
                    // console.log(title)
                    db.query('INSERT INTO videos(title, link, picture, duration, views, likes, dislikes, likePourcent, channel, categories, pornstars, tags, iframe) VALUES ("'+title+'","' + link + '","' + picture + '","' + duration + '","' + views + '","' + likes + '","' + dislikes + '","' + likePourcent + '","' + channel + '","' + categories + '","' + pornstars + '","' + tags + '","' + frame + '")')

                }
            }
            await page2.close();

        }
    }

    await browser.close();
    console.log('yes')
})
();


function sleep(ms) {
    return new Promise((resolve) => {
        setTimeout(resolve, ms);
    });
}



// https://ew.phncdn.com/videos/202105/20/388350961/180P_225K_388350961.webm?validfrom=1622152314&validto=1622159514&rate=150k&burst=1000k&ipa=91.171.122.220&hash=m8%2BKUe7zv2WqfCVEgBHk7UpUeJE%3D
// https://ew.phncdn.com/videos/201802/10/154131272/200724_1411_180P_225K_154131272.webm?validfrom=1622151910&validto=1622159110&rate=150k&burst=1000k&ipa=176.142.244.207&hash=6rLw1L6CH55spbZdx8LVVP3i%2FmM%3D
