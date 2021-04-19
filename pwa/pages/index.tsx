import Head from "next/head";
import Link from "next/link";

const Welcome = () => (
    <>
        <Head>
            <title>Shorten :: url shortener</title>
        </Head>

        <div className="welcome">
            <header className="welcome__top">
                Shorten any URL
            </header>
            <section className="welcome__main">
                <form onSubmit={shortenSubmit} className="welcome__main__form">
                    <label htmlFor="shortenUrlInput">
                        URL:
                    </label>
                    <input id="shortenUrlInput" placeholder="https://google.com" />
                    <input type="submit" value="Shorten" />
                </form>
                <div className="shorten-result"></div>
            </section>
            <footer className="welcome__bottom">
                <div className="welcome__bottom__brand">
                    Url shortener, a recruitment fun project by <a href="//github.com/pawelabrams">@pawelabrams</a>
                </div>
                <div className="welcome__bottom__links">
                    <a href="//github.com/pawelabrams/url-shortener">Code</a> &middot;
                    <a href="/docs">Docs</a> &middot;
                    <a href="/admin">Admin</a>
                </div>
            </footer>

            <style jsx global>{`
                @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700");

                body {
                    margin: 0;
                }

                .welcome {
                    background-color: #fafafa;
                    display: flex;
                    color: #1d1e1c;
                    flex-direction: column;
                    font-family: "Open Sans", sans-serif;
                    min-height: 100vh;
                    overflow: auto;
                    text-align: center;
                    width: 100vw;
                }

                .welcome__top {
                    padding: 1em;
                }

                .welcome__main {
                    flex: 1 0 auto;
                }

                .welcome__main__form {
                    display: flex;
                    align-items: stretch;
                    justify-content: center;
                }

                .welcome__main__form label {
                    text-indent: -1000em;
                }

                .shorten-result {
                    padding: 2em;
                }

                .welcome__bottom {
                    display: flex;
                    flex-shrink: 0;
                    justify-content: space-between;
                }

                .welcome__bottom > div {
                    padding: 1em;
                }
            `}</style>
        </div>
    </>
);
export default Welcome;

const shortenSubmit = (event) => {
    const url = document.getElementById('shortenUrlInput').value;

    fetch('/api/shorten', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        body: JSON.stringify({
            url: url
        })
    })
    .then(response => { if (!response.ok) throw response; else return response; })
    .then(response => response.json())
    .then(data => { document.getElementsByClassName('shorten-result')[0].innerHTML = new URL('/' + data.id, document.baseURI).href; })
    .catch(error => {
        if (error instanceof Response) { error.json().then(data => alert(data.title + "\n" + data.detail)); }
    });

    event.preventDefault();
}
