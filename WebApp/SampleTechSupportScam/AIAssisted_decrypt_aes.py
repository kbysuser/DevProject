import base64
import hashlib
from Crypto.Cipher import AES

def evp_bytestokey(password, salt, key_len, iv_len):
    """
    OpenSSL's EVP_BytesToKey implementation.
    Derives key and IV from password and salt using MD5.
    """
    m = []
    data = password + salt
    while len(b"".join(m)) < (key_len + iv_len):
        m.append(hashlib.md5((m[-1] if len(m) > 0 else b"") + data).digest())
    
    key_iv = b"".join(m)
    key = key_iv[:key_len]
    iv = key_iv[key_len:key_len+iv_len]
    return key, iv

def decrypt_openssl(encrypted_b64, password_str):
    # Decode base64
    data = base64.b64decode(encrypted_b64)
    
    # Check "Salted__" magic header
    if data[:8] != b"Salted__":
        raise ValueError("Invalid OpenSSL salted format")
    
    # Extract salt (next 8 bytes)
    salt = data[8:16]
    ciphertext = data[16:]
    
    # Password as bytes
    password = password_str.encode('utf-8')
    
    # Derive Key and IV (AES-256-CBC needs 32-byte key and 16-byte IV)
    key, iv = evp_bytestokey(password, salt, 32, 16)
    
    print(f"Salt: {salt.hex()}")
    print(f"Key:  {key.hex()}")
    print(f"IV:   {iv.hex()}")
    
    # Decrypt
    cipher = AES.new(key, AES.MODE_CBC, iv)
    decrypted = cipher.decrypt(ciphertext)
    
    # Remove PKCS7 padding
    padding_len = decrypted[-1]
    if padding_len < 1 or padding_len > 16:
        # If padding is invalid, it might be a different key or algorithm
        return decrypted
    
    return decrypted[:-padding_len]

if __name__ == "__main__":
    key_str = "U2FsdGVkX1+uqxI4YN2qNlGDaMHVLViZB05OmcVwVyI="
    # User said "U2FsdGVkX1+uqxI4YN2qNlGDaMHVLViZB05OmcVwVyI= をキーにして"
    # This string itself starts with "U2FsdGVkX1", so it's likely a base64 encoded salted data.
    # But the user calls it a "key". Let's try it as a password first.
    
    with open("./encrypted.txt", "r") as f:
        content = f.read().strip()
    
    try:
        print("--- Attempting Decryption ---")
        result = decrypt_openssl(content, key_str)
        print("\nDecrypted content:")
        print(result.decode('utf-8', errors='replace'))
    except Exception as e:
        print(f"Error: {e}")
