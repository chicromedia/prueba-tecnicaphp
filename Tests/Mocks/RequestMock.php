<?php

namespace Tests\Mocks;

use Phalcon\Http\RequestInterface;

class RequestMock implements RequestInterface
{
    private array $headers = [];

    public function __construct( array $data = [] )
    {
        $_SERVER[ "REQUEST_METHOD" ] = $data[ "method" ] ?: "GET";
        $_POST                       = $data[ "body" ] ?: [];
        $_GET                        = $data[ "query" ] ?: [];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeader( string $name, string $value )
    {
        $_SERVER[ "HTTP_" . strtoupper( $name ) ] = $value;
    }

    public function get( string $name = null, $filters = null, $defaultValue = null, bool $notAllowEmpty = false, bool $noRecursive = false )
    {
        return $name ? $_REQUEST[ $name ] : $defaultValue;
    }

    public function getAcceptableContent(): array
    {
        // TODO: Implement getAcceptableContent() method.
    }

    public function getBasicAuth(): ?array
    {
        // TODO: Implement getBasicAuth() method.
    }

    public function getBestAccept(): string
    {
        // TODO: Implement getBestAccept() method.
    }

    public function getBestCharset(): string
    {
        // TODO: Implement getBestCharset() method.
    }

    public function getBestLanguage(): string
    {
        // TODO: Implement getBestLanguage() method.
    }

    public function getClientAddress( bool $trustForwardedHeader = false )
    {
        // TODO: Implement getClientAddress() method.
    }

    public function getClientCharsets(): array
    {
        // TODO: Implement getClientCharsets() method.
    }

    public function getContentType(): ?string
    {
        // TODO: Implement getContentType() method.
    }

    public function getDigestAuth(): array
    {
        // TODO: Implement getDigestAuth() method.
    }

    public function getHeader( string $header ): string
    {
        return $this->getServer( "HTTP_" . strtoupper( $header ) );
    }

    public function getHttpHost(): string
    {
        return "localhost";
    }

    public function getHTTPReferer(): string
    {
        // TODO: Implement getHTTPReferer() method.
    }

    public function getJsonRawBody( bool $associative = false )
    {
        return json_decode( $this->getRawBody(), $associative );
    }

    public function getLanguages(): array
    {
        // TODO: Implement getLanguages() method.
    }

    public function getMethod(): string
    {
        return $_SERVER[ "REQUEST_METHOD" ];
    }

    public function getPort(): int
    {
        // TODO: Implement getPort() method.
    }

    public function getURI( bool $onlyPath = false ): string
    {
        // TODO: Implement getURI() method.
    }

    public function getPost( string $name = null, $filters = null, $defaultValue = null, bool $notAllowEmpty = false, bool $noRecursive = false )
    {
        return !$name ? $this->getJsonRawBody() : ( $this->getJsonRawBody( true )[ $name ] ?: $defaultValue );
    }

    public function getPut( string $name = null, $filters = null, $defaultValue = null, bool $notAllowEmpty = false, bool $noRecursive = false )
    {
        return $this->getPost( $name, $filters, $defaultValue );
    }

    public function getQuery( string $name = null, $filters = null, $defaultValue = null, bool $notAllowEmpty = false, bool $noRecursive = false )
    {
        return $name ? $_GET[ $name ] : $defaultValue;
    }

    public function getRawBody(): string
    {
        return json_encode( $_POST );
    }

    public function getScheme(): string
    {
        // TODO: Implement getScheme() method.
    }

    public function getServerAddress(): string
    {
        // TODO: Implement getServerAddress() method.
    }

    public function getServerName(): string
    {
        // TODO: Implement getServerName() method.
    }

    public function getUploadedFiles( bool $onlySuccessful = false, bool $namedKeys = false ): array
    {
        // TODO: Implement getUploadedFiles() method.
    }

    public function getUserAgent(): string
    {
        return $this->getHeader( 'user_agent' );
    }

    public function has( string $name ): bool
    {
        return isset( $_SERVER[ $name ] );
    }

    public function hasFiles(): bool
    {
        // TODO: Implement hasFiles() method.
    }

    public function hasHeader( string $header ): bool
    {
        return $this->has( "HTTP_" . strtoupper( $header ) );
    }

    public function hasQuery( string $name ): bool
    {
        // TODO: Implement hasQuery() method.
    }

    public function hasPost( string $name ): bool
    {
        // TODO: Implement hasPost() method.
    }

    public function hasPut( string $name ): bool
    {
        // TODO: Implement hasPut() method.
    }

    public function hasServer( string $name ): bool
    {
        // TODO: Implement hasServer() method.
    }

    public function isAjax(): bool
    {
        // TODO: Implement isAjax() method.
    }

    public function isConnect(): bool
    {
        // TODO: Implement isConnect() method.
    }

    public function isDelete(): bool
    {
        return $this->isMethod( "DELETE" );
    }

    public function isGet(): bool
    {
        return $this->isMethod( "GET" );
    }

    public function isHead(): bool
    {
        // TODO: Implement isHead() method.
    }

    public function isMethod( $methods, bool $strict = false ): bool
    {
        return $_SERVER[ "REQUEST_METHOD" ] === $methods;
    }

    public function isOptions(): bool
    {
        return $this->isMethod( "OPTION" );
    }

    public function isPost(): bool
    {
        return $this->isMethod( "POST" );
    }

    public function isPurge(): bool
    {
        // TODO: Implement isPurge() method.
    }

    public function isPut(): bool
    {
        return $this->isMethod( "PUT" );
    }

    public function isSecure(): bool
    {
        // TODO: Implement isSecure() method.
    }

    public function isSoap(): bool
    {
        // TODO: Implement isSoap() method.
    }

    public function isTrace(): bool
    {
        // TODO: Implement isTrace() method.
    }

    public function numFiles( bool $onlySuccessful = false ): int
    {
        // TODO: Implement numFiles() method.
    }

    public function getServer( string $name ): ?string
    {
        return $this->has( $name ) ? $_SERVER[ $name ] : "";
    }
}
