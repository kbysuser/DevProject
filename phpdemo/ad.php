<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>絶対儲かる副業</title>
    <link rel="stylesheet" href="">
    <style>
        /* *{
            border: 1px solid cyan;
        } */
        body{
            
            font-family: 'Arial',san-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color:#f9f9f9;
            header{
                background-color: #0033ff;
                /* background-color: #333; */
                color: #fff;
                padding: 1em 0;
                text-align: center;
                h1{
                    margin: 0;
                    font-size: 1.8rem;
                }
            }
            main{
                display: grid;
                grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
                gap:2rem;
                padding: 2rem;
                /* max-width: 1200px; */
                max-width: 90svw;
                margin: 0 auto;
                .demo ,.ad{
                    background-color: #fff;
                    padding: 2rem;
                    border-radius: 8px;
                    object-fit: fill;

                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                    h2{
                        margin-top: 0;
                        color: #333;
                    }
                    img{
                        /* width:auto; */
                        /* max-width:90%; */
                        /* width: 90%; */
                        max-height:50%;
                        /* height:auto; */
                        border-radius: 8px;
                        
                    }
                    @media(max-width:600px){
                        img {
                            max-width:100%;
                            height:auto;
                            aspect-ratio: 16/9;
                            object-fit: cover;
                        }
                        
                    }

                }
            }
            footer{
                background-color: #0033ff;
                /* background-color: #333; */
                color: #fff;
                text-align: center;
                padding: 1rem 0;
                margin-top: 2rem;
                position: sticky;
                bottom: -1px;
            }
            /* モバイル対応 */
            @media(max-width:600px){
                body{
                    main{
                        grid-template-columns: 1fr;
                        padding: 1rem;
                        gap: 1rem;
                    }
                }
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>絶対儲かる副業</h1>
    </header>
    <main>
        <section class="ad">
            <h2>絶対儲かる副業</h2>
            <a href="csrf.php" target="_blank" rel="noopener" class="ad-image-link">
                <img src="./img/ad.png"  alt="" srcset="">
            </a>
        </section>
    </main>
    <footer>&copy;絶対儲かる副業</footer>
</body>
</html>